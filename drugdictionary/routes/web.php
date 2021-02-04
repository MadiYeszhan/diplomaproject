<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DBTestController;
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

//Route::get('/', [DBTestController::class, 'index'])->name('test');



//Admin panel
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/drugs/drug_title/{drug_title}', [\App\Http\Controllers\Admin\DrugController::class, 'destroyDrugTitle'])->name('admin.drugTitle.delete');
Route::resource('/admin/drug_categories', \App\Http\Controllers\Admin\DrugCategoryController::class,['except' => [ 'show' ]]);
Route::resource('/admin/disease_categories', \App\Http\Controllers\Admin\DiseaseCategoryController::class,['except' => [ 'show' ]]);
Route::resource('/admin/manufacturers', \App\Http\Controllers\Admin\ManufacturerController::class,['except' => [ 'show' ]]);
Route::resource('/admin/diseases', \App\Http\Controllers\Admin\DiseaseController::class,['except' => [ 'show' ]]);
Route::resource('/admin/drugs', \App\Http\Controllers\Admin\DrugController::class,['except' => [ 'show' ]]);

