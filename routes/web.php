<?php

use App\Http\Controllers\CabinetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\SearchController;
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
    Route::get('help', 'index')->name('index');
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

Route::controller(SearchController::class)
->prefix('search')
->as('search.')
->group(function () {
    Route::post('all', 'all')->name('all');
    Route::get('{search}/work', 'work')->name('work');
    Route::get('{search}/category', 'category')->name('category');
    Route::get('{search}/cabinet', 'cabinet')->name('cabinet');
});

Route::resource('panel/cabinet', CabinetController::class)->except(['show']);
Route::resource('panel/category', CategoryController::class)->except(['show']);
Route::resource('panel/status', StatusController::class)->only(['index', 'edit', 'update']);
Route::resource('panel/priority', PriorityController::class);
Route::resource('panel/work', WorkController::class);
Route::view('/test', 'layouts.app');
