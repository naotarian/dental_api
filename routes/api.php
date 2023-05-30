<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Manage\BasicInformationController;
use App\Http\Controllers\Manage\AccessController;
use App\Http\Controllers\Manage\MedicalTreatmentController;
use App\Http\Controllers\Manage\StaffController;
use App\Http\Controllers\Manage\ShiftController;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum', 'verified'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['auth:manages', 'verified'])->get('/manages/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['auth:manages', 'verified'])->controller(BasicInformationController::class)->group(function () {
    Route::prefix('manages')->group(function () {
        Route::prefix('basic_information')->group(function () {
            Route::post('/update', 'update')->name('basic_information.update');
            Route::get('/', 'fetch')->name('basic_information.fetch');
        });
        Route::prefix('access')->group(function () {
            Route::get('/', 'fetch')->name('access.fetch');
        });
    });
});
Route::middleware(['auth:manages', 'verified'])->controller(AccessController::class)->group(function () {
    Route::prefix('manages')->group(function () {
        Route::prefix('access')->group(function () {
            Route::get('/', 'fetch')->name('access.fetch');
            Route::post('/company_change', 'company_change')->name('access.company_change');
            Route::post('/line_change', 'line_change')->name('access.line_change');
            Route::post('/update', 'update')->name('access.update');
        });
    });
});
Route::middleware(['auth:manages', 'verified'])->controller(MedicalTreatmentController::class)->group(function () {
    Route::prefix('manages')->group(function () {
        Route::prefix('medical_treatment')->group(function () {
            Route::get('/', 'fetch')->name('medical_treatment.fetch');
            Route::post('/update', 'update')->name('medical_treatment.update');
        });
    });
});
Route::middleware(['auth:manages', 'verified'])->controller(StaffController::class)->group(function () {
    Route::prefix('manages')->group(function () {
        Route::prefix('staff')->group(function () {
            Route::get('/', 'fetch')->name('staff.fetch');
            Route::post('/regist', 'regist')->name('staff.regist');
            Route::post('/delete', 'delete')->name('staff.delete');
        });
    });
});
Route::middleware(['auth:manages', 'verified'])->controller(ShiftController::class)->group(function () {
    Route::prefix('manages')->group(function () {
        Route::prefix('shift')->group(function () {
            Route::get('/{date?}', 'fetch')->name('shift.fetch');
            Route::post('/update', 'update')->name('shift.update');
            Route::post('/delete', 'delete')->name('shift.delete');
        });
    });
});
