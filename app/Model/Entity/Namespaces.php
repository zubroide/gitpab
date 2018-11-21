<?php

namespace App\Model\Entity;

/**
 * @property int id
 * @property string name
 * @property string path
 * @property string kind
 * @property string full_path
 * @property int|null parent_id
 */
class Namespaces extends EntityAbstract
{

    const KIND_GROUP = 'group';
    const KIND_USER = 'user';

    /**
     * {@inheritdoc}
     */
    protected $table = 'namespace';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'id',
        'name',
        'path',
        'kind',
        'full_path',
        'parent_id',
    ];

}
