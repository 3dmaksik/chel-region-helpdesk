<?php

use App\Http\Controllers\CabinetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\WorkController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();
Route::controller(HelpController::class)
->prefix('panel')
->as('help.')
->group(function () {
    Route::get('help/all', 'index')->name('index');
    Route::get('help/new', 'new')->name('new');
    Route::get('help/worker', 'worker')->name('worker');
    Route::get('help/completed', 'completed')->name('completed');
    Route::get('help/dismiss', 'dismiss')->name('dismiss');
    Route::post('help', 'store')->name('store');
    Route::get('help/create', 'create')->name('create');
    Route::patch('help/{help}', 'update')->name('update');
    Route::get('help/{help}', 'show')->name('show');
    Route::delete('help/{help}', 'destroy')->name('destroy');
    Route::get('help/{help}/edit', 'edit')->name('edit');
    Route::patch('help/{help}/accept', 'accept')->name('accept');
    Route::patch('help/{help}/execute', 'execute')->name('execute');
    Route::patch('help/{help}/reject', 'reject')->name('reject');
    Route::patch('help/{help}/redefine', 'redefine')->name('redefine');
});

Route::controller(HomeController::class)
->prefix('user')
->as('user.')
->group(function () {
    Route::post('all', 'store')->name('store');
    Route::get('worker', 'worker')->name('worker');
    Route::get('completed', 'completed')->name('completed');
    Route::get('dismiss', 'dismiss')->name('dismiss');
    Route::get('create', 'create')->name('create');
    Route::get('{help}', 'show')->name('show');
});

Route::controller(SearchController::class)
->prefix('search')
->as('search.')
->group(function () {
    Route::post('all', 'all')->name('all');
    Route::get('{search}/work', 'work')->name('work');
    Route::get('{search}/category', 'category')->name('category');
    Route::get('{search}/cabinet', 'cabinet')->name('cabinet');
});

Route::controller(SettingsController::class)
->prefix('panel')
->as('settings.')
->group(function () {
    Route::get('settings/edit', 'edit')->name('edit');
    Route::patch('settings/update/password', 'updatePassword')->name('updatePassword');
    Route::patch('settings/update/settings', 'updateSettings')->name('updateSettings');
});

Route::resource('panel/cabinet', CabinetController::class)->except(['show']);
Route::resource('panel/category', CategoryController::class)->except(['show']);
Route::resource('panel/status', StatusController::class)->only(['index', 'edit', 'update']);
Route::resource('panel/priority', PriorityController::class);
Route::resource('panel/work', WorkController::class);
Route::view('/test', 'layouts.app');
