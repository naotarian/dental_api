<?php

use App\Http\Controllers\Auth\Manage\AuthenticatedSessionController;
use App\Http\Controllers\Auth\Manage\ConfirmablePasswordController;
use App\Http\Controllers\Auth\Manage\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\Manage\NewPasswordController;
use App\Http\Controllers\Auth\Manage\PasswordResetLinkController;
use App\Http\Controllers\Auth\Manage\RegisteredUserController;
use App\Http\Controllers\Auth\Manage\VerifyEmailController;

use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisteredUserController::class, 'store'])
  ->middleware('guest:manages');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
  ->middleware('guest:manages');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
  ->middleware('guest:manages')
  ->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
  ->middleware('guest:manages')
  ->name('password.update');

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
  ->middleware(['auth:manages', 'signed', 'throttle:6,1'])
  ->name('verification.verify');
Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
  ->middleware(['auth:manages', 'throttle:6,1'])
  ->name('verification.send');

Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
  ->middleware('auth:manages');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
  ->middleware('auth:manages')
  ->name('logout');

Route::get('/reset-password/{token}', function ($token) {
  return redirect()->intended(config('app.manage_url') . '/reset-password/' . $token);
})->middleware('guest:manages')->name('password.reset');
