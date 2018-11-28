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

use App\Http\Controllers\ContributorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (!Auth::user()) {
        return redirect('login');
    }
    return redirect('home');
});

Auth::routes();

Route::group(['middleware' => ['auth', 'route_permission']], function () {

    Route::get('/home', '\\' . HomeController::class . '@index')->name('home');

    Route::resource('project', '\\' . ProjectController::class);
    Route::resource('milestone', '\\' . MilestoneController::class);
    Route::resource('issue', '\\' . IssueController::class);
    Route::resource('note', '\\' . NoteController::class);
    Route::resource('time', '\\' . TimeController::class);
    Route::resource('contributor', '\\' . ContributorController::class);
    Route::resource('payment', '\\' . PaymentController::class);
    Route::resource('user', '\\' . UserController::class);

});
