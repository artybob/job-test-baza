<?php

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
    return view('job_task');
});

Route::post('/process_file', [\App\Http\Controllers\FileController::class, 'processFile']);

Route::post('/change_folders', [\App\Http\Controllers\FileController::class, 'changeFolders']);
