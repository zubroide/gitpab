<?php

namespace App\Model\Entity;
use App\User;

/**
 * @property int id
 * @property string title
 * @property string description
 * @property float amount
 * @property float hour_rate
 * @property float hours
 * @property int status_id
 * @property string payment_date
 * @property int contributor_id
 * @property int created_by_id
 * @property int updated_by_id
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
        'amount',
        'hour_rate',
        'hours',
        'status_id',
        'payment_date',
        'contributor_id',
        'created_by_id',
        'updated_by_id',
    ];

    public function contributor()
    {
        return $this->belongsTo(Contributor::class, 'contributor_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(PaymentStatus::class, 'status_id', 'id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id', 'id');
    }

    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_by_id', 'id');
    }

}
