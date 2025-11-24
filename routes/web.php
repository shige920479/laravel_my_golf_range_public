<?php

use App\Http\Controllers\GuestController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\ClearSessionController;
use App\Http\Controllers\User\MypageController;
use App\Http\Controllers\User\ReserveController;
use App\Http\Controllers\User\TempRegisterController;
use App\Http\Controllers\User\UserRegisterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function() {
    return view('home');
})->name('home');

Route::get('/price', [GuestController::class, 'showPrice'])->name('showPrice');
Route::post('/clearSession', [ClearSessionController::class, 'clearSession'])->name('user.clearSession');

Route::controller(TempRegisterController::class)
->group(function(){
    Route::get('/temporary', 'create')->name('user.temporary.create');
    Route::post('/temporary', 'store')->name('user.temporary.store');
    Route::get('/temporary/guide/{token}', 'showGuide')->name('user.temporary.guide');
});

Route::controller(UserRegisterController::class)
->group(function() {
    Route::get('/registration/{token}', 'create')->name('user.registration.create');
    Route::post('/registration/{token}', 'store')->name('user.registration.store');
    Route::get('/registration/confirm/{token}', 'confirm')->name('user.registration.confirm');
    Route::post('/registration/confirm/{token}', 'send')->name('user.registration.send');
    Route::get('/registration/complete/{token}', 'complete')->name('user.registration.complete');
});

Route::controller(AuthController::class)
->middleware('guest:users')
->group(function(){
    Route::get('/loginForm', 'loginForm')->name('user.loginForm');
    Route::post('/login', 'login')->name('user.login');
});

Route::middleware('auth:users')
->name('user.')
->group(function () {
    Route::get('/reserve', [ReserveController::class, 'create'])->name('reserve.create');
    Route::post('/reserve', [ReserveController::class, 'store'])->name('reserve.store');
    Route::get('/reserve/confirm', [ReserveController::class, 'confirm'])->name('reserve.confirm');
    Route::post('/reserve/confirm', [ReserveController::class, 'send'])->name('reserve.send');
    Route::get('/reserve/complete', [ReserveController::class, 'complete'])->name('reserve.complete');
    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage.index');
    Route::get('/mypage/cancel/complete', [MypageController::class, 'cancelComplete'])->name('mypage.cancel.complete');
    Route::get('/mypage/{id}', [MypageController::class, 'edit'])->name('mypage.edit');
    Route::post('/mypage/{id}', [MypageController::class, 'store'])->name('mypage.store');
    Route::get('/mypage/{id}/confirm', [MypageController::class, 'confirm'])->name('mypage.confirm');
    Route::post('/mypage/{id}/confirm', [MypageController::class, 'send'])->name('mypage.send');
    Route::get('/mypage/{id}/complete', [MypageController::class, 'complete'])->name('mypage.complete');
    Route::get('/mypage/{id}/cancel', [MypageController::class, 'cancelConfirm'])->name('mypage.cancel.confirm');
    Route::post('/mypage/{id}/cancel', [MypageController::class, 'cancelExec'])->name('mypage.cancel.exec');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});