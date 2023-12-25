<?php

use App\Http\Controllers\AdminController;
use App\Http\Middleware\PreventBackHistory;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->name('admin.')->group(function(){

    Route::middleware(['guest:admin','PreventBackHistory'])->group(function(){
        Route::view('/login','back.pages.admin.auth.login')->name('login');
        Route::view('/register','back.pages.admin.auth.register')->name('register');
        Route::post('/login_handler',[AdminController::class,'LoginHandler'])->name('login_handler');
        Route::view('/forgot-password','back.pages.admin.auth.forgot-password')->name('forgot-password');
        Route::post('/send-password-reset-link',[AdminController::class,'SendPasswordResetLink'])->name('send-password-reset-link');
        Route::get('/password/reset/{token}',[AdminController::class,'resetPassword'])->name('reset-password');
        Route::post('/reset-password—handler',[AdminController::class,'resetPasswordHandler'])->name('reset-password-handler');
    
    });
    Route::middleware(['auth:admin','PreventBackHistory'])->group(function(){
        Route::view('/home','back.pages.admin.home')->name('home');
        Route::post('/logout_handler',[AdminController::class,'LogoutHandler'])->name('logout_handler');
        Route::get('/profile',[AdminController::class,'ProfileView'])->name('profile');
        Route::post('/change-profile-photo',[AdminController::class,'ChangePhoto'])->name('change-profile-photo');
        Route::view('/settings','back.pages.admin.settings')->name('settings');
        Route::post('/change-logo',[AdminController::class,'ChangeLogo'])->name('change-logo');
        Route::post('/change-favicon',[AdminController::class,'ChangeFavicon'])->name('change-favicon');
    });

});