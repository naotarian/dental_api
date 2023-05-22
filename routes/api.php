<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Manage\BasicInformationController;
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
    });
});
