<?php

use Illuminate\Support\Facades\Route;
use app\Http\Controllers\HomeController;
use App\Mail\MyEmail;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

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
    return view('example-auth');
});

Route::view('/example-page','example-page');
Route::view('/example-auth','example-auth');

Route::get('/test', function() {
    $name = "Funny code";
    Mail::to(users:'acepbahari@gmail.com')->send(new WelcomeMail($name));
});

// Route untuk halaman utama
// Route::get('/', [HomeController::class, 'index'])->name('home');

// // Route untuk halaman-halaman lainnya
// Route::get('/fitur', [HomeController::class, 'fitur'])->name('fitur');
// Route::get('/tentang', [HomeController::class, 'tentang'])->name('tentang');
// Route::get('/galeri', [HomeController::class, 'galeri'])->name('galeri');
// Route::get('/data', [HomeController::class, 'data'])->name('data');
