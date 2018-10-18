<?php

namespace App\Model\Entity;

/**
 * @property int id
 * @property int iid
 * @property int group_id
 * @property int project_id
 * @property string title
 * @property string description
 * @property string state
 * @property string start_date
 * @property string due_date
 * @property string gitlab_created_at
 * @property string gitlab_updated_at
 * @property string web_url
 */
class Milestone extends EntityAbstract
{

    /**
     * {@inheritdoc}
     */
    protected $table = 'milestone';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'id',
        'iid',
        'group_id',
        'project_id',
        'title',
        'description',
        'state',
        'start_date',
        'due_date',
        'gitlab_created_at',
        'gitlab_updated_at',
        'web_url',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function group()
    {
        return $this->belongsTo(Namespaces::class, 'group_id');
    }

    public function issues()
    {
        return $this->hasMany(Issue::class)
            ->orderBy('issue.iid');
    }

}
