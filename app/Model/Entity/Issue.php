<?php

namespace App\Model\Entity;

/**
 * Class Filter
 * @package App\Model\Entities
 *
 * @property int id
 * @property int iid
 * @property int project_id
 * @property string title
 * @property string description
 * @property string gitlab_created_at
 * @property string gitlab_updated_at
 * @property int author_id
 * @property int assignee_id
 * @property string web_url
 */
class Issue extends EntityAbstract
{

    /**
     * {@inheritdoc}
     */
    protected $table = 'issue';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'id',
        'iid',
        'project_id',
        'title',
        'description',
        'gitlab_created_at',
        'gitlab_updated_at',
        'author_id',
        'assignee_id',
        'web_url',
    ];

}
