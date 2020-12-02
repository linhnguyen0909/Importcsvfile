<?php

use App\Http\Controllers\ImportCsvController;
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

Route::get('files',[ImportCsvController::class,'importCsvFile']);
Route::get('import-file',[ImportCsvController::class,'csvFile'])->name('import-file');
