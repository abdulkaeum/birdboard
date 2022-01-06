<?php

use App\Http\Controllers\ProjectInvitationsController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ProjectsTasksController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::group(['middleware' => 'auth'], function(){
    /*Route::get('projects', [ProjectsController::class, 'index'])->name('projects.index');
    Route::get('projects/create', [ProjectsController::class, 'create']);
    Route::get('projects/{project}', [ProjectsController::class, 'show']);
    Route::get('projects/{project}/edit', [ProjectsController::class, 'edit']);
    Route::patch('projects/{project}', [ProjectsController::class, 'update']);
    Route::post('projects', [ProjectsController::class, 'store']);
    Route::delete('projects/{project}', [ProjectsController::class, 'destroy']);*/
    Route::resource('projects', ProjectsController::class);

    Route::post('projects/{project}/tasks', [ProjectsTasksController::class, 'store']);
    Route::patch('projects/{project}/tasks/{task}', [ProjectsTasksController::class, 'update']);

    Route::post('projects/{project}/invitations', [ProjectInvitationsController::class, 'store']);
});

