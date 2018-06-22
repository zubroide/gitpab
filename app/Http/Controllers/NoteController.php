<?php

namespace App\Http\Controllers;

use App\Model\Service\Eloquent\EloquentNoteService;

class NoteController extends CrudController
{
    /**
     * @return EloquentNoteService
     */
    protected function getService()
    {
        return app(EloquentNoteService::class);
    }

}
