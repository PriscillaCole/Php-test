<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//route to the project store method
Route::post('/projects', [ProjectController::class, 'store'])->name('store');
Route::get('/projects',[ProjectController::class, 'index'])->name('projects_table');
Route::get('/projects/{id}', [ProjectController::class, 'show'])->name('show');
Route::get('/projects/{id}/edit', [ProjectController::class, 'edit'])->name('edit');
Route::put('/projects/{id}', [ProjectController::class, 'update'])->name('update');
Route::delete('/projects/{id}', [ProjectController::class, 'destroy'])->name('delete');
