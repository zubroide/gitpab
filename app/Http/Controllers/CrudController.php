<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormRequest;
use App\Http\Requests\ListRequest;
use App\Model\Service\Eloquent\CrudServiceAbstract;
use App\Model\Service\ServiceException;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\{
    App, Log, Auth, Redirect
};
use Symfony\Component\HttpFoundation\BinaryFileResponse;

abstract class CrudController extends Controller
{
    protected $name = null;

    /**
     * @var array Default map of actions to requests
     */
    protected $requestMap = [
        'index' => ListRequest::class,
    ];

    public function __construct()
    {
        $this->bindActionRequest();
    }

    /**
     * @return CrudServiceAbstract
     */
    abstract protected function getService();

    protected function bindActionRequest()
    {
        $action = $this->getAction();

        if (isset($this->requestMap[$action])) {
            App::bind(FormRequest::class, $this->requestMap[$action]);
        }
    }

    /**
     * CRUD - Entity list
     * @param FormRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(FormRequest $request)
    {
        if ($request->get('submit') === 'csv') {
            $data = $this->getService()->getCompleteList($request->all());
            return $this->downloadCsv($data);
        }

        $view = $this->getView('index');

        $data = $this->prepareDataForIndex($request, [
            'itemsList'      => $this->getService()->getList($request->all()),
            'request'        => $request,
            'indexRoute'     => $this->getRoute('index'),
            'createRoute'    => $this->getRoute('create'),
            'editRoute'      => $this->getRoute('edit'),
            'showRoute'      => $this->getRoute('show'),
            'destroyRoute'   => $this->getRoute('destroy'),
            'order'          => $request->getOrder(),
            'orderDirection' => $request->getOrderDirection(),
        ]);

        return view($view, $data);
    }

    public function downloadCsv(\Generator $data): BinaryFileResponse
    {
        $filename = tempnam(storage_path('temp'), 'gitpab_');
        $file = fopen($filename, 'r+');

        $isFirstLine = true;
        foreach ($data as $line) {
            $row = $line->toArray();
            foreach ($row as &$value) {
                if (is_array($value)) {
                    $value = implode(', ', $value);
                }
            }
            if ($isFirstLine) {
                $isFirstLine = false;
                fputcsv($file, array_keys($row));
            }
            fputcsv($file, $row);
        }

        $headers = [
            'Content-Type: text/csv',
        ];

        fclose($file);

        $result = response()
            ->download($filename, 'gitpab-export.csv', $headers)
            ->deleteFileAfterSend(true);

        return $result;
    }

    /**
     * CRUD - Create entity form
     * @param FormRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(FormRequest $request)
    {
        $view = $this->getView('create');

        $data = $this->prepareDataForCreate($request, [
            'storeRoute' => $this->getRoute('store'),
            'indexRoute' => $this->getRoute('index'),
            'backUrl' => $this->getBackUrl($request),
        ]);

        return view($view, $data);
    }

    /**
     * CRUD - Store entity
     * @param FormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FormRequest $request)
    {
        $backUrl = $this->getBackUrl($request);

        $errorMessage = null;

        try {
            $requestData = $request->all();
            /** @var User $curUser */
            $curUser = Auth::user();
            if (!empty($curUser) AND empty($requestData['user_id'])) {
                $requestData['user_id'] = $curUser->id;
            }

            if ($created = $this->getService()->create($requestData)) {
                return Redirect::to($backUrl)->withMessage('Success');
            }
        }
        catch (ServiceException $e) {
            $errorMessage = $e->getMessage();
        }
        catch (\Throwable $e) {
            Log::error($e->getMessage());
            $errorMessage = __('messages.Error on create record');
        }

        $view = $this->getView('create');

        $indexRoute = $this->getRoute('index');
        $storeRoute = $this->getRoute('store');

        $data = $this->prepareDataForEdit($request, [
            'errorMessage' => $errorMessage,
            'storeRoute' => $storeRoute,
            'indexRoute' => $indexRoute,
            'backUrl' => $backUrl,
            'object' => (object)($request->all()),
        ]);

        return view($view, $data);
    }

    /**
     * CRUD - Show entity page
     * @param FormRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(FormRequest $request)
    {
        $id = $this->getRouteParamId($request);
        $indexRoute = $this->getRoute('index');
        $editRoute = $this->getRoute('edit');
        $backUrl = $this->getBackUrl($request);

        try {
            $object = $this->getService()->getObjectForEdit($id);
        }
        catch (ModelNotFoundException $e) {
            return redirect()->route($indexRoute)->with('alert', 'Record not found');
        }

        $view = $this->getView('show');

        $data = $this->prepareDataForShow($request, [
            'editRoute' => $editRoute,
            'indexRoute' => $indexRoute,
            'backUrl' => $backUrl,
            'object' => $object,
        ]);

        return view($view, $data);
    }

    /**
     * CRUD - Edit entity form
     * @param FormRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(FormRequest $request)
    {
        $id = $this->getRouteParamId($request);
        $indexRoute = $this->getRoute('index');
        $updateRoute = $this->getRoute('update');
        $backUrl = $this->getBackUrl($request);

        try {
            $object = $this->getService()->getObjectForEdit($id);
        }
        catch (ModelNotFoundException $e) {
            return redirect()->route($indexRoute)->with('alert', 'Record not found');
        }

        $view = $this->getView('edit');

        $data = $this->prepareDataForEdit($request, [
            'updateRoute' => $updateRoute,
            'indexRoute' => $indexRoute,
            'backUrl' => $backUrl,
            'object' => $object,
        ]);

        return view($view, $data);
    }

    /**
     * CRUD - update record
     * @param FormRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(FormRequest $request)
    {
        $id = $this->getRouteParamId($request);
        $backUrl = $this->getBackUrl($request);

        $errorMessage = null;

        try {
            if ($updated = $this->getService()->update($request->all(), $id)) {
                return Redirect::to($backUrl)->withMessage('Data updated successfully');
            }
        }
        catch (ServiceException $e) {
            $errorMessage = $e->getMessage();
        }
        catch (\Throwable $e) {
            Log::error($e->getMessage());
            $errorMessage = 'Error on update record';
        }

        $indexRoute = $this->getRoute('index');
        $updateRoute = $this->getRoute('update');

        $view = $this->getView('edit');

        $data = $this->prepareDataForEdit($request, [
            'errorMessage' => $errorMessage,
            'updateRoute' => $updateRoute,
            'indexRoute' => $indexRoute,
            'backUrl' => $backUrl,
            'object' => (object)($request->all() + ['id' => $id]),
        ]);

        return view($view, $data);
    }

    /**
     * CRUD - Delete record
     * @param FormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(FormRequest $request)
    {
        $id = $this->getRouteParamId($request);

        if ($id) {
            try {
                if ($deleted = $this->getService()->delete($id)) {
                    return $this->jsonSuccess();
                }
            }
            catch (ServiceException $e) {
                return $this->jsonError($e->getMessage());
            }
            catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }

        return $this->jsonError('Error on delete');
    }

    /**
     * @param $acton
     * @return string
     */
    protected function getRoute($acton)
    {
        return $this->getName() . '.' . $acton;
    }

    /**
     * @param $acton
     * @return string
     */
    protected function getView($acton)
    {
        return 'gitpab/' . $this->getName() . '/' . $acton;
    }

    /**
     * Get controller alias
     *
     * @return null|string
     */
    protected function getName()
    {
        if (null === $this->name && preg_match('/(?P<name>[\w]+)Controller$/i', get_class($this), $matches))
        {
            $this->name = snake_case($matches['name']);
        }

        return $this->name;
    }

    /**
     * @return string|null
     */
    protected function getAction()
    {
        $route = $this->getCurrentRoute();

        if (null != $route)
        {
            $actionName = $route->getActionName();
            $action = (preg_match('/@(?P<action>.+)$/i', $actionName, $matches)) ? $matches['action'] : null;
            return $action;
        }

        return null;
    }

    /**
     * @return \Illuminate\Routing\Route|mixed
     */
    protected function getCurrentRoute()
    {
        if (!$this->route)
        {
            $this->route = app(Route::class);
        }
        return $this->route;
    }

    /**
     * Get ID from route
     * @param Request $request
     * @return int
     */
    protected function getRouteParamId(Request $request)
    {
        $parameterName = $this->getName();
        return (int)$request->route()->parameter($parameterName);
    }

    /**
     * Get url for redirect to back (form for create/edit)
     * @param Request $request
     * @return string
     */
    protected function getBackUrl(Request $request)
    {
        $backUrl = $request->input('back_url');
        if (empty($backUrl))
        {
            $backUrl = route($this->getRoute('index'));
        }
        return $backUrl;
    }

    /**
     * @param FormRequest $request
     * @param array $data
     * @return array
     */
    protected function prepareDataForIndex(FormRequest $request, array $data)
    {
        return $data;
    }

    /**
     * @param FormRequest $request
     * @param array $data
     * @return array
     */
    protected function prepareDataForCreate(FormRequest $request, array $data)
    {
        return $data;
    }

    /**
     * @param FormRequest $request
     * @param array $data
     * @return array
     */
    protected function prepareDataForEdit(FormRequest $request, array $data)
    {
        return $data;
    }

    /**
     * @param FormRequest $request
     * @param array $data
     * @return array
     */
    protected function prepareDataForShow(FormRequest $request, array $data)
    {
        return $data;
    }
}