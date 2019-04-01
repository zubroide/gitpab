<?php

namespace App\Model\Repository;

use Illuminate\Database\Eloquent\Builder;
use App\Model\Entity\Payment;

class PaymentRepositoryEloquent extends RepositoryAbstractEloquent
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Payment::class;
    }

    public function getListQuery(array $parameters): Builder
    {
        $query = parent::getListQuery($parameters)
            ->leftJoin('contributor', 'contributor.id', '=', 'payment.contributor_id')
            ->join('payment_status', 'payment_status.id', '=', 'payment.status_id')
        ;

        return $query;
    }

}