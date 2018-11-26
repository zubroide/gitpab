<?php

namespace App\Model\Service\Eloquent;

use App\Model\Repository\PaymentStatusRepositoryEloquent;
use App\Providers\AppServiceProvider;

/**
 * @property PaymentStatusRepositoryEloquent $repository
 */
class EloquentPaymentStatusService extends CrudServiceAbstract
{

    public function __construct()
    {
        $this->repository = app(AppServiceProvider::PAYMENT_STATUS_REPOSITORY);
    }

    public function getAllStatuses()
    {
        return $this->repository->get()->pluck('name')->toArray();
    }

}