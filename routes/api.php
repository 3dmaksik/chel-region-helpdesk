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
    Route::post('help/new', [IndexApiController::class, 'store'])->name('index.store')->middleware('can:store help');
});
Route::middleware('auth')->middleware('throttle:100,1')->group(function () {

    Route::post('loader/post', [LoaderApiController::class, 'index'])->middleware('can:loader help');
    Route::post('help/all', [HelpApiController::class, 'getAllPages'])->middleware('can:all help');
    Route::controller(CabinetApiController::class)
        ->prefix('admin/cabinet')
        ->as('cabinet.')
        ->group(function () {
            Route::post('', 'store')->name('store')->middleware('can:create cabinet');
            Route::patch('{cabinet}', 'update')->name('update')->middleware('can:update cabinet');
            Route::delete('{cabinet}', 'destroy')->name('destroy')->middleware('can: delete cabinet');
        });
    Route::controller(CategoryApiController::class)
        ->prefix('admin/category')
        ->as('category.')
        ->group(function () {
            Route::post('', 'store')->name('store')->middleware('can:create category');
            Route::patch('{category}', 'update')->name('update')->middleware('can:update category');
            Route::delete('{category}', 'destroy')->name('destroy')->middleware('can:delete category');
        });
    Route::controller(StatusApiController::class)
        ->prefix('admin/status')
        ->as('status.')
        ->group(function () {
            Route::patch('{status}', 'update')->name('update')->middleware('can:update status');
        });
    Route::controller(PriorityApiController::class)
        ->prefix('admin/priority')
        ->as('priority.')
        ->group(function () {
            Route::post('', 'store')->name('store')->middleware('can:create priority');
            Route::patch('{priority}', 'update')->name('update')->middleware('can:update priority');
            Route::delete('{priority}', 'destroy')->name('destroy')->middleware('can:delete priority');
        });
    Route::controller(UserApiController::class)
        ->prefix('admin/users')
        ->as('users.')
        ->group(function () {
            Route::post('', 'store')->name('store')->middleware('can:create user');
            Route::patch('{user}', 'update')->name('update')->middleware('can:update user');
            Route::delete('{user}', 'destroy')->name('destroy')->middleware('can:delete user');
        });
    Route::controller(HelpApiController::class)
        ->prefix('admin')
        ->as('help.')
        ->group(function () {
            Route::post('help', 'store')->name('store')->middleware('can:create help');
            Route::patch('{help}', 'update')->name('update')->middleware('can:update help');
            Route::patch('{help}/accept', 'accept')->name('accept')->middleware('can:accept help');
            Route::patch('{help}/reject', 'reject')->name('reject')->middleware('can:reject help');
            Route::patch('{help}/redefine', 'redefine')->name('redefine')->middleware('can:redefine help');
            Route::patch('{help}/execute', 'execute')->name('execute')->middleware('can:execute help');
        });
    Route::get('help/new', [HelpApiController::class, 'newPagesCount'])->middleware('can:count help');
    Route::get('help/now', [HelpApiController::class, 'nowPagesCount'])->middleware('can:count help');
    Route::controller(NewsApiController::class)
        ->prefix('news')
        ->as('news.')
        ->group(function () {
            Route::post('news', 'store')->name('store')->middleware('can:create news');
            Route::patch('{news}', 'update')->name('update')->middleware('can:update news');
            Route::delete('{news}', 'destroy')->name('destroy')->middleware('can:delete news');
        });
    Route::controller(HomeApiController::class)
        ->prefix('home')
        ->as('home.')
        ->group(function () {
            Route::post('help', 'store')->name('store')->middleware('can:create home help');
        });
    Route::controller(SettingsApiController::class)
        ->prefix('settings')
        ->as('settings.')
        ->group(function () {
            Route::patch('update/password', 'updatePassword')->name('updatePassword')->middleware('can:update settings');
            Route::patch('update/settings', 'updateSettings')->name('updateSettings')->middleware('can:update settings');
        });
});
