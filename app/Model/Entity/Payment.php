<?php

namespace App\Model\Entity;

/**
 * @property int id
 * @property string title
 * @property string description
 * @property int status_id
 * @property string payment_date
 * @property int user_id
 */
class Payment extends EntityAbstract
{

    /**
     * {@inheritdoc}
     */
    protected $table = 'payment';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'id',
        'title',
        'description',
        'status_id',
        'payment_date',
        'user_id',
    ];

}
