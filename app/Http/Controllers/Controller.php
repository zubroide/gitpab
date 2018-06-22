<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Route;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     *
     * @var Route Lazy, use only with $this->getCurrentRoute()
     */
    protected $route;

    const JSON_RESULT_SUCCESS = 'success';
    const JSON_RESULT_ERROR = 'error';

    const CODE_SUCCESS = 200;
    const CODE_NOT_FOUND = 404;
    const CODE_ERROR = 500;

    protected function jsonSuccess($params = [], $message = null)
    {
        return response()->json(
            [
                'status' => [
                    'result' => self::JSON_RESULT_SUCCESS,
                    'code' => self::CODE_SUCCESS,
                    'message' => $message,
                ],
                'data' => $params,
            ]
        );
    }

    protected function jsonError($message = null, $code = null, $data = [])
    {
        return response()->json(
            [
                'status' => [
                    'result' => self::JSON_RESULT_ERROR,
                    'code' => $code ?: self::CODE_ERROR,
                    'message' => $message,
                ],
                'data' => $data,
            ]
        );
    }
}
