<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DBTestController;
use App\Http\Controllers\Main\MainController;
use App\Http\Controllers\Main\SearchController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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



//Main pages
Route::get('/', [MainController::class, 'drugs'])->name('main.index');
Route::get('/drugs', [MainController::class, 'drugs'])->name('main.drugs');
Route::get('/diseases', [MainController::class, 'diseases'])->name('main.diseases');
///Details pages
Route::get('/drugs/details/{id}', [MainController::class, 'drug'])->name('main.drugs.details');
Route::get('/side_effects/details/{id}', [MainController::class, 'drugs'])->name('main.side_effects.details');
Route::get('/diseases/details/{id}', [MainController::class, 'drugs'])->name('main.diseases.details');
Route::get('/manufacturers/details/{id}', [MainController::class, 'drugs'])->name('main.manufacturers.details');

Route::get('/parse', [\App\Http\Controllers\Main\ParseController::class, 'parseAptekaPlus'])->name('main.parse');

//Searching pages
///Search drugs
Route::get('/drugs/search', [SearchController::class, 'searchText'])->name('searchText');
Route::get('/drugs/alphabet/{letter}', [SearchController::class, 'searchDrugAlphabet'])->name('searchDrugAlphabet');
Route::get('/drugs/number', [SearchController::class, 'searchDrugNumber'])->name('searchDrugNumber');
///Search disease
Route::get('/disease/search', [SearchController::class, 'searchDiseaseText'])->name('searchDiseaseText');
Route::get('/disease/alphabet/{letter}', [SearchController::class, 'searchDiseaseAlphabet'])->name('searchDiseaseAlphabet');


//Admin panel
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/drugs/drug_title/{drug_title}', [\App\Http\Controllers\Admin\DrugController::class, 'destroyDrugTitle'])->name('admin.drugTitle.delete');
Route::resource('/admin/drug_categories', \App\Http\Controllers\Admin\DrugCategoryController::class,['except' => [ 'show' ]]);
Route::resource('/admin/disease_categories', \App\Http\Controllers\Admin\DiseaseCategoryController::class,['except' => [ 'show' ]]);
Route::resource('/admin/manufacturers', \App\Http\Controllers\Admin\ManufacturerController::class,['except' => [ 'show' ]]);
Route::resource('/admin/diseases', \App\Http\Controllers\Admin\DiseaseController::class,['except' => [ 'show' ]]);
Route::resource('/admin/drugs', \App\Http\Controllers\Admin\DrugController::class,['except' => [ 'show' ]]);

//User Authentication
Route::get('/login', [LoginController::class, 'loginForm'])->name('loginform');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'registerForm'])->name('registerform');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
Route::get('/email/verify', function () {return view('auth.verify');})->middleware(['auth'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

//User profile
Route::post('profile/addDisease', [ProfileController::class, 'addDisease'])->name('addDisease');
Route::delete('profile/addDisease/{disease_id}', [ProfileController::class, 'removeDisease'])->name('removeDisease');


