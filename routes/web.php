<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\SurveyorController;

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
//-----------------------------------------------------
Route::get('/', function () {
    return view('welcome');
});

Route::get('/table', function () {
    return view('table');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//==============ADMIN ROUTES==============
Route::get('admin-page', [CityController::class, 'index'])->middleware('role:admin')->name('admin.page');
Route::post('store-city', [CityController::class, 'store']);
Route::post('edit-city', [CityController::class, 'edit']);
Route::post('delete-city', [CityController::class, 'destroy']);

Route::put('fast-assign', [CityController::class, 'fastAssign']);
Route::put('batch-assign', [CityController::class, 'batchAssign']);
Route::put('batch-unassign', [CityController::class, 'batchUnassign']);
Route::put('batch-confirm', [CityController::class, 'batchConfirm']);
Route::put('set-confirm', [CityController::class, 'setConfirm']);
Route::put('batch-delete', [CityController::class, 'batchDelete']);
//==============SURVEYOR ROUTES==============
Route::get('surveyor-page', [SurveyorController::class, 'indexSurveyor'])->middleware('role:user')->name('surveyor.page');
Route::put('batch-done', [SurveyorController::class, 'batchDone']);
Route::put('batch-undone', [SurveyorController::class, 'batchUndone']);
Route::put('mark-done', [SurveyorController::class, 'markDone']);
Route::put('mark-undone', [SurveyorController::class, 'markUndone']);
