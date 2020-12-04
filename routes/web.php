<?php

use App\Http\Controllers\ImportFileController;
use App\Http\Controllers\ImportExcelController;
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

Route::get('files',[ImportFileController::class,'importFile']);
Route::post('import-file',[ImportFileController::class,'import'])->name('file-import');
Route::get('import-excel',[ImportExcelController::class,'importFileExcel']);
Route::get('excel',[ImportExcelController::class,'read']);
