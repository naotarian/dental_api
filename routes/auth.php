<?php

use App\Http\Controllers\Auth\Portal\AuthenticatedSessionController;
use App\Http\Controllers\Auth\Portal\ConfirmablePasswordController;
use App\Http\Controllers\Auth\Portal\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\Portal\NewPasswordController;
use App\Http\Controllers\Auth\Portal\PasswordResetLinkController;
use App\Http\Controllers\Auth\Portal\RegisteredUserController;
use App\Http\Controllers\Auth\Portal\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisteredUserController::class, 'store'])
  ->middleware('guest');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
  ->middleware('guest');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
  ->middleware('guest')
  ->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
  ->middleware('guest')
  ->name('password.update');

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
  ->middleware(['auth', 'throttle:6,1'])
  ->name('verification.verify');
Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
  ->middleware(['auth', 'throttle:6,1'])
  ->name('verification.send');

Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
  ->middleware('auth');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
  ->middleware('auth')
  ->name('logout');

Route::get('/reset-password/{token}', function ($token) {
  return redirect()->intended(config('app.frontend_url') . '/reset-password/' . $token);
})->middleware('guest')->name('password.reset');
