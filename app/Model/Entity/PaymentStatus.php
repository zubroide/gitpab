<?php

namespace App\Model\Entity;

/**
 * @property int id
 * @property string alias
 * @property string title
 * @property string description
 */
class PaymentStatus extends EntityAbstract
{
    const PAYED = 'payed';
    const CANCEL = 'cancel';

    /**
     * {@inheritdoc}
     */
    protected $table = 'payment_status';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'id',
        'alias',
        'title',
        'description',
    ];

}
