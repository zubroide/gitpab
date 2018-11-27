<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormRequest;
use App\Http\Requests\ListRequest;
use App\Http\Requests\StorePaymentRequest;
use App\Model\Repository\ContributorRepositoryEloquent;
use App\Model\Repository\PaymentStatusRepositoryEloquent;
use App\Model\Service\Eloquent\EloquentPaymentService;
use App\Providers\AppServiceProvider;

class PaymentController extends CrudController
{
    protected $requestMap = [
        'store' => StorePaymentRequest::class,
        'index' => ListRequest::class,
    ];

    /**
     * @return EloquentPaymentService
     */
    protected function getService()
    {
        return app(EloquentPaymentService::class);
    }

    protected function prepareDataForCreate(FormRequest $request, array $data)
    {
        /** @var PaymentStatusRepositoryEloquent $paymentStatusRepository */
        $paymentStatusRepository = app(AppServiceProvider::PAYMENT_STATUS_REPOSITORY);

        /** @var ContributorRepositoryEloquent $contributorRepository */
        $contributorRepository = app(AppServiceProvider::CONTRIBUTOR_REPOSITORY);

        return array_merge(
            $data,
            [
                'statusList' => $paymentStatusRepository->getItemsForSelect(null, null, 'id', 'title'),
                'contributorList' => $contributorRepository->getItemsForSelect(['' => '-']),
            ]
        );
    }

    protected function prepareDataForEdit(FormRequest $request, array $data)
    {
        /** @var PaymentStatusRepositoryEloquent $paymentStatusRepository */
        $paymentStatusRepository = app(AppServiceProvider::PAYMENT_STATUS_REPOSITORY);

        return array_merge(
            $data,
            [
                'statusList' => $paymentStatusRepository->getItemsForSelect(null, null, 'id', 'title'),
            ]
        );
    }
}
