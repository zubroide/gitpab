<?php

namespace App\Model\Entity;

/**
 * @property int id
 * @property string name
 * @property string description
 */
class Label extends EntityAbstract
{

    /**
     * {@inheritdoc}
     */
    protected $table = 'label';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'id',
        'name',
        'description',
    ];

}
