<?php

namespace App\Model\Entity;

/**
 * @property int id
 * @property string name
 * @property string description
 * @property string path_with_namespace
 * @property int namespace_id
 * @property string web_url
 * @property string ssh_url_to_repo
 * @property string http_url_to_repo
 * @property string creator_id
 */
class Project extends EntityAbstract
{

    /**
     * {@inheritdoc}
     */
    protected $table = 'project';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'id',
        'name',
        'description',
        'path_with_namespace',
        'namespace_id',
        'web_url',
        'ssh_url_to_repo',
        'http_url_to_repo',
        'creator_id',
    ];

}
