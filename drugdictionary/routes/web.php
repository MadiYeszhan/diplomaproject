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



//Main routes
Route::get('/', [MainController::class, 'drugs'])->name('main.index');
Route::get('/drugs', [MainController::class, 'drugs'])->name('main.drugs');
Route::get('/diseases', [MainController::class, 'diseases'])->name('main.diseases');
Route::get('/language/{lang}', [MainController::class, 'changeLanguage'])->name('main.language');
///Details routes
Route::get('/drugs/details/{id}', [MainController::class, 'drug'])->name('main.drugs.details');
Route::get('/side_effects/details/{id}', [MainController::class, 'drugs'])->name('main.side_effects.details');
Route::get('/diseases/details/{id}', [MainController::class, 'drugs'])->name('main.diseases.details');
Route::get('/manufacturers/details/{id}', [MainController::class, 'drugs'])->name('main.manufacturers.details');
///Comment creation routes
Route::get('/drugs/details/{id}/comment', [MainController::class, 'createComment'])->name('main.drugs.createComment')->middleware(\App\Http\Middleware\MuteCheck::class);
Route::post('/drugs/details/comment', [MainController::class, 'storeComment'])->name('main.drugs.storeComment')->middleware(\App\Http\Middleware\MuteCheck::class);
Route::get('/drugs/details/comment/{id}', [MainController::class, 'deleteComment'])->name('main.drugs.deleteComment');


//Searching routes
///Search drugs
Route::get('/drugs/search', [SearchController::class, 'searchText'])->name('searchText');
Route::get('/drugs/alphabet/{letter}', [SearchController::class, 'searchDrugAlphabet'])->name('searchDrugAlphabet');
Route::get('/drugs/number', [SearchController::class, 'searchDrugNumber'])->name('searchDrugNumber');
///Search disease
Route::get('/disease/search', [SearchController::class, 'searchDiseaseText'])->name('searchDiseaseText');
Route::get('/disease/alphabet/{letter}', [SearchController::class, 'searchDiseaseAlphabet'])->name('searchDiseaseAlphabet');


//Admin panel routes
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/drugs/drug_title/{drug_title}', [\App\Http\Controllers\Admin\DrugController::class, 'destroyDrugTitle'])->name('admin.drugTitle.delete');
Route::get('/admin/drugs/drug_image/{drug_image}', [\App\Http\Controllers\Admin\DrugController::class, 'destroyDrugImage'])->name('admin.drugImage.delete');
Route::resource('/admin/drug_categories', \App\Http\Controllers\Admin\DrugCategoryController::class,['except' => [ 'show' ]]);
Route::resource('/admin/disease_categories', \App\Http\Controllers\Admin\DiseaseCategoryController::class,['except' => [ 'show' ]]);
Route::resource('/admin/manufacturers', \App\Http\Controllers\Admin\ManufacturerController::class,['except' => [ 'show' ]]);
Route::resource('/admin/diseases', \App\Http\Controllers\Admin\DiseaseController::class,['except' => [ 'show' ]]);
Route::resource('/admin/drugs', \App\Http\Controllers\Admin\DrugController::class,['except' => [ 'show' ]]);
Route::resource('/admin/pharmacy_links', \App\Http\Controllers\Admin\PharmacyLinkController::class,['except' => [ 'show','edit','update']]);

Route::get('/admin/users/', [\App\Http\Controllers\AdminController::class, 'showUsers'])->name('admin.users');
Route::post('/admin/users/', [\App\Http\Controllers\AdminController::class, 'muteUser'])->name('admin.users.mute');
Route::delete('/admin/users/{user}', [\App\Http\Controllers\AdminController::class, 'destroyUser'])->name('admin.users.delete');

//User Authentication routes
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

//User profile routes
Route::post('profile/addDisease', [ProfileController::class, 'addDisease'])->name('addDisease');
Route::delete('profile/addDisease/{disease_id}', [ProfileController::class, 'removeDisease'])->name('removeDisease');


