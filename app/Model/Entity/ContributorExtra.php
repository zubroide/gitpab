<?php

namespace App\Model\Entity;

/**
 * @property int contributor_id
 * @property float hour_rate
 * @property int created_by_id
 * @property int updated_by_id
 */
class ContributorExtra extends EntityAbstract
{

    /**
     * {@inheritdoc}
     */
    protected $table = 'contributor_extra';

    protected $primaryKey = 'contributor_id';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'contributor_id',
        'hour_rate',
        'created_by_id',
        'updated_by_id',
    ];

}
