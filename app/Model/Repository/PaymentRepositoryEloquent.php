<?php

namespace App\Model\Repository;

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

}