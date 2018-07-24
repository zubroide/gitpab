<?php

namespace App\Http\Controllers;

use App\Model\Repository\RepositoryAbstractEloquent;
use App\Model\Repository\SpentRepositoryEloquent;
use App\Providers\AppServiceProvider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** @var RepositoryAbstractEloquent $projectRepo */
        $projectRepo = app(AppServiceProvider::PROJECT_REPOSITORY);

        /** @var RepositoryAbstractEloquent $issueRepo */
        $issueRepo = app(AppServiceProvider::ISSUE_REPOSITORY);

        /** @var RepositoryAbstractEloquent $noteRepo */
        $noteRepo = app(AppServiceProvider::NOTE_REPOSITORY);

        /** @var SpentRepositoryEloquent $spentRepo */
        $spentRepo = app(AppServiceProvider::SPENT_REPOSITORY);

        return view('home', [
            'projects' => $projectRepo->count(),
            'issues' => $issueRepo->count(),
            'notes' => $noteRepo->count(),
            'spent' => $spentRepo->sum(),
        ]);
    }
}
