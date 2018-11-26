<?php

namespace App\Model\Repository;

use App\Model\Entity\PaymentStatus;

class PaymentStatusRepositoryEloquent extends RepositoryAbstractEloquent
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PaymentStatus::class;
    }

}