<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\HomeController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\UserController;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (!Auth::user()) {
        return redirect('login');
    }
    return redirect('home');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', '\\' . HomeController::class . '@index')
        ->name('home')
        ->middleware('permission:' . User::PERMISSION_VIEW_SPENT_TIME)
    ;

    Route::resource('project', '\\' . ProjectController::class)
        ->middleware('permission:' . User::PERMISSION_VIEW_PROJECTS);
    Route::resource('milestone', '\\' . MilestoneController::class)
        ->middleware('permission:' . User::PERMISSION_VIEW_PROJECTS);
    Route::resource('issue', '\\' . IssueController::class)
        ->middleware('permission:' . User::PERMISSION_VIEW_ISSUES);
    Route::resource('note', '\\' . NoteController::class)
        ->middleware('permission:' . User::PERMISSION_VIEW_COMMENTS);
    Route::resource('time', '\\' . TimeController::class)
        ->middleware('permission:' . User::PERMISSION_VIEW_SPENT_TIME);
    Route::resource('user', '\\' . UserController::class)
        ->middleware([
            'permission:' . User::PERMISSION_VIEW_USERS,
            'permission:' . User::PERMISSION_EDIT_USERS,
        ]);
    Route::resource('payment', '\\' . PaymentController::class)
        ->middleware([
            'permission:' . User::PERMISSION_VIEW_PAYMENTS,
            'permission:' . User::PERMISSION_EDIT_PAYMENTS,
        ]);
});
