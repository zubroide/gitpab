<?php

namespace App\Model\Entity;

/**
 * @property int id
 * @property string name
 * @property string username
 * @property string state
 * @property string avatar_url
 * @property string web_url
 * @property ContributorExtra extra
 */
class Contributor extends EntityAbstract
{

    /**
     * {@inheritdoc}
     */
    protected $table = 'contributor';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'id',
        'name',
        'username',
        'state',
        'avatar_url',
        'web_url',
    ];

    public function extra()
    {
        return $this->hasOne(ContributorExtra::class);
    }

}
