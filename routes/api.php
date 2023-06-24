<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Manage\BasicInformationController;
use App\Http\Controllers\Manage\AccessController;
use App\Http\Controllers\Manage\MedicalTreatmentController;
use App\Http\Controllers\Manage\StaffController;
use App\Http\Controllers\Manage\ShiftController;
use App\Http\Controllers\Manage\UnitController;
use App\Http\Controllers\Manage\SearchController;
use App\Http\Controllers\Portal\DentalListController;
use App\Http\Controllers\Portal\ReserveController;
use App\Http\Controllers\Manage\ReserveController as ManageReserve;
use App\Http\Controllers\Manage\ReserveCalendarController;
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
Route::middleware(['auth:manages', 'verified'])->controller(UnitController::class)->group(function () {
    Route::prefix('manages')->group(function () {
        Route::prefix('unit')->group(function () {
            Route::get('/', 'fetch')->name('unit.fetch');
            Route::post('/update', 'update')->name('unit.update');
            Route::post('/delete', 'delete')->name('unit.delete');
        });
    });
});
Route::middleware(['auth:manages', 'verified'])->controller(ManageReserve::class)->group(function () {
    Route::prefix('manages')->group(function () {
        Route::prefix('reserve')->group(function () {
            Route::get('/list', 'list')->name('reserve.list');
            Route::post('/detail', 'detail')->name('reserve.detail');
            Route::post('/listSearch', 'listSearch')->name('reserve.listSearch');
            Route::post('/update', 'update')->name('reserve.update');
        });
    });
});
Route::middleware(['auth:manages', 'verified'])->controller(ReserveCalendarController::class)->group(function () {
    Route::prefix('manages')->group(function () {
        Route::prefix('reserve_calendar')->group(function () {
            Route::get('/fetch', 'fetch')->name('reserve_calendar.fetch');
            Route::post('/regist', 'regist')->name('reserve_calendar.regist');
        });
    });
});
Route::middleware(['auth:manages', 'verified'])->controller(SearchController::class)->group(function () {
    Route::prefix('manages')->group(function () {
        Route::prefix('search')->group(function () {
            Route::get('/fetch', 'fetch')->name('search.fetch');
            Route::post('/update', 'update')->name('search.update');
        });
    });
});

//Portal
Route::controller(DentalListController::class)->group(function () {
    Route::prefix('portal')->group(function () {
        Route::prefix('dental')->group(function () {
            Route::get('/', 'fetch')->name('dental.fetch');
            Route::post('/', 'fetch')->name('dental.fetch');
            Route::post('/detail', 'detail')->name('dental.detail');
        });
    });
});
Route::controller(ReserveController::class)->group(function () {
    Route::prefix('portal')->group(function () {
        Route::prefix('reserve')->group(function () {
            Route::post('/calendar', 'calendar')->name('reserve.calendar');
            Route::post('/regist', 'regist')->name('reserve.regist');
            Route::post('/day_list', 'day_list')->name('reserve.day_list');
        });
    });
});
