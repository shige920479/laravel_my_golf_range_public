<?php

use App\Http\Controllers\Owner\AuthController;
use App\Http\Controllers\Owner\InitSettingController;
use App\Http\Controllers\Owner\SettingController;
use Illuminate\Support\Facades\Route;

// RouteServiceProvider でprefix('owner')としているので、パスの頭に/ownerが付与される

Route::middleware('guest:owners')
->name('owner.')
->group(function () {
  Route::get('/login', [AuthController::class, 'loginForm'])->name('loginForm');
  Route::post('/login', [AuthController::class, 'login'])->name('login');  
});

Route::post('/logout', [AuthController::class, 'logout'])->name('owner.logout')
->middleware('auth:owners');


Route::middleware('auth:owners')
->controller(SettingController::class)
->name('owner.')
->group(function() {
  Route::get('/settings', 'showSettings')->name('settings');
  Route::get('/settings/rangeFee', 'rangeFeeForm')->name('settings.rangeFeeForm');
  Route::post('/settings/rangeFee/{redirect}', 'setNewRangeFee')->name('settings.setNewRangeFee');
  Route::get('/settings/rentalFee', 'rentalFeeForm')->name('settings.rentalFeeForm');
  Route::post('/settings/rentalFee/{redirect}', 'setNewRentalFee')->name('settings.setNewRentalFee');
  Route::get('/settings/showerFee', 'showerFeeForm')->name('settings.showerFeeForm');
  Route::post('/settings/showerFee/{redirect}', 'setNewShowerFee')->name('settings.setNewShowerFee');
  Route::get('/settings/mainte/{type}/{id}', 'mainteForm')->name('settings.MainteForm');
  Route::post('/settings/mainte/{type}/{id}', 'setNewMainte')->name('settings.setNewMainte');
});

Route::middleware('auth:owners')
->controller(InitSettingController::class)
->name('owner.')
->group(function() {
  Route::get('/init', 'initForm')->name('initForm');
  Route::post('/init/setDrivingRange', 'setDrivingRange')->name('setDrivingRange');
  Route::post('/init/setRental', 'setRental')->name('setRental');
});