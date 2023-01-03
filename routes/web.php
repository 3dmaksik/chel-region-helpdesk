<?php

use App\Http\Controllers\CabinetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
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
    Route::get('new', 'new')->name('new');
    Route::get('worker', 'workerAdmin')->name('worker');
    Route::get('completed', 'completedAdmin')->name('completed');
    Route::get('dismiss', 'dismiss')->name('dismiss');
    Route::post('help', 'store')->name('store');
    Route::get('create', 'create')->name('create');
    Route::patch('{help}', 'update')->name('update');
    Route::get('{help}/show', 'show')->name('show');
    Route::delete('{help}', 'destroy')->name('destroy');
    Route::get('{help}/edit', 'edit')->name('edit');
    Route::patch('{help}/accept', 'accept')->name('accept');
    Route::patch('{help}/execute', 'execute')->name('execute');
    Route::patch('{help}/reject', 'reject')->name('reject');
    Route::patch('{help}/redefine', 'redefine')->name('redefine');
});

Route::controller(HelpController::class)
->prefix('mod')
->as('mod.')
->group(function () {
    Route::get('worker', 'workerManager')->name('worker');
    Route::get('completed', 'completedManager')->name('completed');
});

Route::controller(HelpController::class)
->prefix('admin')
->as('help.')
->group(function () {
    Route::get('all', 'index')->name('index');
});

Route::controller(HomeController::class)
->prefix('user')
->as('user.')
->group(function () {
    Route::post('help', 'store')->name('store');
    Route::get('worker', 'worker')->name('worker');
    Route::get('completed', 'completed')->name('completed');
    Route::get('dismiss', 'dismiss')->name('dismiss');
    Route::get('create', 'create')->name('create');
    Route::get('{help}/show', 'show')->name('show');
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
->prefix('settings')
->as('settings.')
->group(function () {
    Route::get('edit', 'edit')->name('edit');
    Route::patch('update/password', 'updatePassword')->name('updatePassword');
    Route::patch('update/settings', 'updateSettings')->name('updateSettings');
});

Route::resource('admin/cabinet', CabinetController::class)->except(['show']);
Route::resource('admin/category', CategoryController::class)->except(['show']);
Route::resource('admin/status', StatusController::class)->only(['index', 'edit', 'update']);
Route::resource('admin/priority', PriorityController::class);
Route::resource('admin/work', WorkController::class);
Route::resource('admin/users', UserController::class);
Route::view('/test', 'layouts.app');
