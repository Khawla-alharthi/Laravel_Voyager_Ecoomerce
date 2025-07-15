<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StaticController;
use TCG\Voyager\Facades\Voyager;
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
    return view('layout.base');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

// Development/Testing Routes (remove in production)
Route::get('/base', function () {
    return view('layout.base');
})->name('base');

Route::get('/test-nav', function () {
    return view('layout.nav');
})->name('nav');

Route::get('/test-footer', function () {
    return view('layout.footer');
})->name('footer');


// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('post.login');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('post.register');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::get('/privacy-policy', [StaticController::class, 'privacyPolicy'])->name('privacy.policy');
Route::get('/term-of-service', [StaticController::class, 'termOfServices'])->name('terms.service');

// products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
