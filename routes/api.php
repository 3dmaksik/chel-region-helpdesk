<?php

use App\Http\Controllers\Api\CabinetApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\HelpApiController;
use App\Http\Controllers\Api\HomeApiController;
use App\Http\Controllers\Api\IndexApiController;
use App\Http\Controllers\Api\LoaderApiController;
use App\Http\Controllers\Api\NewsApiController;
use App\Http\Controllers\Api\PriorityApiController;
use App\Http\Controllers\Api\SettingsApiController;
use App\Http\Controllers\Api\StatusApiController;
use App\Http\Controllers\Api\UserApiController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('guest')->middleware('throttle:10,1')->group(function () {
    Route::post('help/new', [IndexApiController::class, 'store'])->name('index.store');
});
Route::middleware('auth')->middleware('throttle:100,1')->group(function () {
    Route::middleware(['role:superAdmin'])->group(function () {
        Route::post('help/all', [HelpApiController::class, 'getAllPages']);
        Route::controller(CabinetApiController::class)
        ->prefix('admin/cabinet')
        ->as('cabinet.')
        ->group(function () {
            Route::post('', 'store')->name('store');
            Route::patch('{cabinet}', 'update')->name('update');
            Route::delete('{cabinet}', 'destroy')->name('destroy');
        });
        Route::controller(CategoryApiController::class)
            ->prefix('admin/category')
            ->as('category.')
            ->group(function () {
                Route::post('', 'store')->name('store');
                Route::patch('{category}', 'update')->name('update');
                Route::delete('{category}', 'destroy')->name('destroy');
            });
        Route::controller(StatusApiController::class)
            ->prefix('admin/status')
            ->as('status.')
            ->group(function () {
                Route::patch('{status}', 'update')->name('update');
            });
        Route::controller(PriorityApiController::class)
            ->prefix('admin/priority')
            ->as('priority.')
            ->group(function () {
                Route::post('', 'store')->name('store');
                Route::patch('{priority}', 'update')->name('update');
                Route::delete('{priority}', 'destroy')->name('destroy');
            });
            Route::controller(UserApiController::class)
            ->prefix('admin/users')
            ->as('users.')
            ->group(function () {
                Route::post('', 'store')->name('store');
                Route::patch('{user}', 'update')->name('update');
                Route::delete('{user}', 'destroy')->name('destroy');
            });
    });
    Route::middleware(['role:admin|superAdmin'])->group(function () {
        Route::controller(HelpApiController::class)
        ->prefix('admin')
        ->as('help.')
        ->group(function () {
            Route::post('help', 'store')->name('store');
            Route::patch('{help}/accept', 'accept')->name('accept');
            Route::patch('{help}/reject', 'reject')->name('reject');
            Route::patch('{help}/redefine', 'redefine')->name('redefine');
        });
        Route::controller(NewsApiController::class)
            ->prefix('news')
            ->as('news.')
            ->group(function () {
                Route::post('news', 'store')->name('store');
                Route::patch('{news}', 'update')->name('update');
                Route::delete('{news}', 'destroy')->name('destroy');
            });
    });
    Route::middleware(['role:admin|superAdmin|manager'])->group(function () {
        Route::controller(HelpApiController::class)
        ->prefix('admin')
        ->as('help.')
        ->group(function () {
            Route::patch('{help}/execute', 'execute')->name('execute');
            Route::patch('{help}', 'update')->name('update');
        });
    });
    Route::middleware(['role:admin|superAdmin|manager|user'])->group(function () {
        Route::controller(HomeApiController::class)
            ->prefix('home')
            ->as('home.')
            ->group(function () {
                Route::post('help', 'store')->name('store');
            });
            Route::controller(SettingsApiController::class)
            ->prefix('settings')
            ->as('settings.')
            ->group(function () {
                Route::patch('update/password', 'updatePassword')->name('updatePassword');
                Route::patch('update/settings', 'updateSettings')->name('updateSettings');
            });
            Route::get('help/new', [HelpApiController::class, 'newPagesCount']);
            Route::get('help/now', [HelpApiController::class, 'nowPagesCount']);
            Route::get('loader/get', [LoaderApiController::class, 'index']);
    });
});
