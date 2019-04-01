<?php

namespace App\Http\Requests;

class TimeListRequest extends ListRequest
{
    protected $orderFields = [
        'spent.note_id',
        'spent.hours',
        'note.created_at',
        'contributor.name',
        'project.name',
    ];

    protected $defaultOrder = 'spent.note_id';
}
