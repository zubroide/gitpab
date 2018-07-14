<?php

namespace App\Http\Requests;

class TimeListRequest extends ListRequest
{
    protected $orderFields = ['spent.note_id', 'spent.hours'];
    protected $defaultOrder = 'spent.note_id';
}
