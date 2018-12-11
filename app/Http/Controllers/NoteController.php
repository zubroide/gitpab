<?php

namespace App\Http\Controllers;

use App\Model\Service\Eloquent\EloquentNoteService;
use App\Providers\AppServiceProvider;

class NoteController extends CrudController
{
    /**
     * @return EloquentNoteService
     */
    protected function getService()
    {
        return app(AppServiceProvider::ELOQUENT_NOTE_SERVICE);
    }

}
