<?php

namespace App\Model\Entity;
use App\User;

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
        'hours',
        'status_id',
        'payment_date',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(PaymentStatus::class, 'status_id', 'id');
    }

}
