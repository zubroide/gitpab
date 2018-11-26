<?php

namespace App\Model\Service\Eloquent;

use App\Model\Repository\PaymentRepositoryEloquent;
use App\Providers\AppServiceProvider;

/**
 * @property PaymentRepositoryEloquent $repository
 */
class EloquentPaymentService extends CrudServiceAbstract
{

    public function __construct()
    {
        $this->repository = app(AppServiceProvider::PAYMENT_REPOSITORY);
    }

}