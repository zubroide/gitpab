<?php

namespace App\Model\Entity;

use App\Helper\PgHelper;

/**
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
 * @property int milestone_id
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
        'state',
        'labels',
        'milestone_id',
        'estimate',
        'closed_at',
    ];

    public function assignee()
    {
        return $this->belongsTo(Contributor::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function setLabelsAttribute($items)
    {
        $this->attributes['labels'] = PgHelper::toPgArray($items);
    }

    public function getLabelsAttribute()
    {
        return PgHelper::arrayParse($this->attributes['labels']);
    }

}
