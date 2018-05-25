<?php

namespace App\Model\Entity;

/**
 * Class Filter
 * @package App\Model\Entities
 *
 * @property int id
 * @property string name
 * @property string description
 * @property string path_with_namespace
 * @property string namespace_id
 * @property string namespace_full_path
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
        'namespace_full_path',
        'web_url',
        'ssh_url_to_repo',
        'http_url_to_repo',
        'creator_id',
    ];

}
