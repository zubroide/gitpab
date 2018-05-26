<?php

namespace App\Model\Entity;

/**
 * @property int id
 * @property int issue_id
 * @property string body
 * @property int author_id
 * @property string gitlab_created_at
 * @property string gitlab_updated_at
 */
class Note extends EntityAbstract
{

    /**
     * {@inheritdoc}
     */
    protected $table = 'note';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'id',
        'issue_id',
        'body',
        'author_id',
        'gitlab_created_at',
        'gitlab_updated_at',
    ];

}
