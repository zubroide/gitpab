<?php

namespace App\Model\Entity;

/**
 * @property int note_id
 * @property Note note
 * @property float hours
 * @property string spent_at
 * @property string description
 */
class Spent extends EntityAbstract
{

    /**
     * {@inheritdoc}
     */
    protected $table = 'spent';

    /**
     * {@inheritdoc}
     */
    protected $primaryKey = 'note_id';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'note_id',
        'hours',
        'spent_at',
        'description',
    ];

    public function note()
    {
        return $this->belongsTo(Note::class, 'note_id', 'id');
    }

}
