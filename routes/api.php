<?php

use App\Http\Controllers\Api\CabinetApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\HelpApiController;
use App\Http\Controllers\Api\HomeApiController;
use App\Http\Controllers\Api\IndexApiController;
use App\Http\Controllers\Api\NewsApiController;
use App\Http\Controllers\Api\PriorityApiController;
use App\Http\Controllers\Api\SearchApiController;
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

Route::middleware('guest')->middleware('throttle:10,1')->group(function (): void {
    Route::post('help/new', [IndexApiController::class, 'store'])->name('index.store')->middleware('can:store help');
});
Route::middleware('auth')->middleware('throttle:100,1')->group(function (): void {
    Route::post('help/all', [HelpApiController::class, 'getAllPages'])->middleware('can:all help');
    Route::get('select2/cabinet', [SearchApiController::class, 'cabinet'])->name('select2.cabinet')->middleware('can:create cabinet');
    Route::controller(CabinetApiController::class)
        ->prefix('admin/cabinet')
        ->as('cabinet.')
        ->group(function (): void {
            Route::post('', 'store')->name('store')->middleware('can:create cabinet');
            Route::patch('{cabinet}', 'update')->name('update')->middleware('can:update cabinet');
            Route::delete('{cabinet}', 'destroy')->name('destroy')->middleware('can:destroy cabinet');
        });
    Route::controller(CategoryApiController::class)
        ->prefix('admin/category')
        ->as('category.')
        ->group(function (): void {
            Route::post('', 'store')->name('store')->middleware('can:create category');
            Route::patch('{category}', 'update')->name('update')->middleware('can:update category');
            Route::delete('{category}', 'destroy')->name('destroy')->middleware('can:destroy category');
        });
    Route::controller(StatusApiController::class)
        ->prefix('admin/status')
        ->as('status.')
        ->group(function (): void {
            Route::patch('{status}', 'update')->name('update')->middleware('can:update status');
        });
    Route::controller(PriorityApiController::class)
        ->prefix('admin/priority')
        ->as('priority.')
        ->group(function (): void {
            Route::post('', 'store')->name('store')->middleware('can:create priority');
            Route::patch('{priority}', 'update')->name('update')->middleware('can:update priority');
            Route::delete('{priority}', 'destroy')->name('destroy')->middleware('can:destroy priority');
        });
    Route::controller(UserApiController::class)
        ->prefix('admin/users')
        ->as('users.')
        ->group(function (): void {
            Route::post('', 'store')->name('store')->middleware('can:create user');
            Route::put('{user}', 'update')->name('update')->middleware('can:update user');
            Route::patch('{user}', 'updatePassword')->name('password')->middleware('can:update user');
            Route::delete('{user}', 'destroy')->name('destroy')->middleware('can:destroy user');
        });
    Route::controller(HelpApiController::class)
        ->prefix('admin')
        ->as('help.')
        ->group(function (): void {
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
        ->group(function (): void {
            Route::post('news', 'store')->name('store')->middleware('can:create news');
            Route::patch('{news}', 'update')->name('update')->middleware('can:update news');
            Route::delete('{news}', 'destroy')->name('destroy')->middleware('can:destroy news');
        });
    Route::controller(HomeApiController::class)
        ->prefix('home')
        ->as('home.')
        ->group(function (): void {
            Route::post('help', 'store')->name('store')->middleware('can:create home help');
        });
    Route::controller(SettingsApiController::class)
        ->prefix('settings')
        ->as('settings.')
        ->group(function (): void {
            Route::patch('update/password', 'updatePassword')->name('updatePassword')->middleware('can:update settings');
            Route::patch('update/settings', 'updateSettings')->name('updateSettings')->middleware('can:update settings');
        });
});
