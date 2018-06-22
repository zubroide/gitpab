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
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TimeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', '\\' . HomeController::class . '@index')->name('home');

    Route::resource('project', '\\' . ProjectController::class);
//    Route::get('project/{id}', '\\' . ProjectController::class . '@view')->name('project.view');
    Route::resource('issue', '\\' . IssueController::class);
    Route::resource('note', '\\' . NoteController::class);
    Route::resource('time', '\\' . TimeController::class);

});