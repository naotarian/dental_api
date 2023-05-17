<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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
Route::redirect('/', config('app.frontend_url'))->name('top');
Route::redirect('/manage_login', config('app.manage_url') . '/login')->name('manage_login');
Route::redirect('/login', config('app.portal_url') . '/login')->name('portal_login');
Route::redirect('/adminLogin', config('app.frontend_url') . '/admin/login')->name('adminLogin');
require __DIR__ . '/auth.php';
Route::prefix('manages')->name('manages.')->group(function () {
  require __DIR__ . '/manage.php';
});

