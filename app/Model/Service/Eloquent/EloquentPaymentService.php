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

    public function getBalance()
    {
        /** @var EloquentContributorService $contributorService */
        $contributorService = app(AppServiceProvider::ELOQUENT_CONTRIBUTOR_SERVICE);
        $list = $contributorService->getCompleteList([]);
        $balance = 0;
        foreach ($list as $item) {
            $balance += $item->balance;
        }
        return $balance;
    }

}