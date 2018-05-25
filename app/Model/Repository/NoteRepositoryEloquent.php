<?php

namespace App\Model\Repository;

use App\Model\Entity\Note;

class NoteRepositoryEloquent extends RepositoryAbstractEloquent
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Note::class;
    }
}