<?php

namespace App\Model\Entity;

/**
 * @property int note_id
 * @property float hours
 * @property string description
 */
class Spent extends EntityAbstract
{

    /**
     * {@inheritdoc}
     */
    protected $table = 'spent';

    /**
     * {@inheritdoc}
     */
    protected $primaryKey = 'note_id';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'note_id',
        'hours',
        'description',
    ];

}
