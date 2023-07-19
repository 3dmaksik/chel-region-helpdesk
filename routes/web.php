<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CabinetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
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
Route::middleware('guest')->group(function (): void {
    Route::get('/', [IndexController::class, 'index'])->name('index');
    Route::post('login', [LoginController::class, 'login'])->name('login')->middleware('start.form')->middleware('throttle:10,10');
});

Route::middleware('auth')->group(function (): void {
    Route::controller(HelpController::class)
        ->prefix('admin')
        ->as('help.')
        ->group(function (): void {
            Route::get('helps/all', 'index')->name('index')->middleware('can:all help');
            Route::get('helps/pagination', 'getIndex')->name('getIndex')->middleware('can:all help');
            Route::get('helps/new', 'new')->name('new')->middleware('can:new help');
            Route::post('helps/new', 'getNew')->name('new')->middleware('can:new help');
            Route::get('create', 'create')->name('create')->middleware('can:create help');
            Route::get('helps/dismiss', 'dismiss')->name('dismiss')->middleware('can:dismiss help');
            Route::post('helps/dismiss', 'getDismiss')->name('dismiss')->middleware('can:dismiss help');
            Route::get('{help}/edit', 'edit')->name('edit')->middleware('can:edit help');
            Route::get('{help}/show', 'show')->name('show')->middleware('can:view help');
            Route::post('{help}/show', 'getShow')->name('show')->middleware('can:view help');
            Route::get('helps/worker', 'worker')->name('worker')->middleware('can:worker help');
            Route::post('helps/worker', 'getWorker')->name('worker')->middleware('can:worker help');
            Route::get('helps/completed', 'completed')->name('completed')->middleware('can:completed help');
            Route::post('helps/completed', 'getCompleted')->name('completed')->middleware('can:completed help');
        });
    Route::controller(CabinetController::class)
        ->prefix('admin/cabinet')
        ->as('cabinet.')
        ->group(function (): void {
            Route::get('', 'index')->name('index')->middleware('can:view cabinet');
            Route::post('', 'getIndex')->name('getIndex')->middleware('can:view cabinet');
            Route::get('create', 'create')->name('create')->middleware('can:create cabinet');
            Route::get('{cabinet}/edit', 'edit')->name('edit')->middleware('can:edit cabinet');
        });
    Route::controller(CategoryController::class)
        ->prefix('admin/category')
        ->as('category.')
        ->group(function (): void {
            Route::get('', 'index')->name('index')->middleware('can:view category');
            Route::get('create', 'create')->name('create')->middleware('can:create category');
            Route::get('{category}/edit', 'edit')->name('edit')->middleware('can:edit category');
        });
    Route::controller(StatusController::class)
        ->prefix('admin/status')
        ->as('status.')
        ->group(function (): void {
            Route::get('', 'index')->name('index')->middleware('can:view status');
            Route::get('{status}/edit', 'edit')->name('edit')->middleware('can:edit status');
        });
    Route::controller(PriorityController::class)
        ->prefix('admin/priority')
        ->as('priority.')
        ->group(function (): void {
            Route::get('', 'index')->name('index')->middleware('can:view priority');
            Route::get('create', 'create')->name('create')->middleware('can:create priority');
            Route::get('{priority}/show', 'show')->name('show')->middleware('can:view priority');
            Route::get('{priority}/edit', 'edit')->name('edit')->middleware('can:edit priority');
        });
    Route::controller(UserController::class)
        ->prefix('admin/users')
        ->as('users.')
        ->group(function (): void {
            Route::get('', 'index')->name('index')->middleware('can:view user');
            Route::get('create', 'create')->name('create')->middleware('can:create user');
            Route::get('{user}/show', 'show')->name('show')->middleware('can:view user');
            Route::get('{user}/edit', 'edit')->name('edit')->middleware('can:edit user');
        });
    Route::controller(NewsController::class)
        ->prefix('news')
        ->as('news.')
        ->group(function (): void {
            Route::get('create', 'create')->name('create')->middleware('can:create news');
            Route::get('{news}/edit', 'edit')->name('edit')->middleware('can:edit news');
            Route::get('', 'index')->name('index')->middleware('can:view news');
            Route::get('{news}/show', 'show')->name('show')->middleware('can:view news');
        });
    Route::controller(HomeController::class)
        ->prefix('home')
        ->as('home.')
        ->group(function (): void {
            Route::get('helps/worker', 'worker')->name('worker')->middleware('can:worker home help');
            Route::post('helps/worker', 'getWorker')->name('worker')->middleware('can:worker home help');
            Route::get('helps/completed', 'completed')->name('completed')->middleware('can:completed home help');
            Route::post('helps/completed', 'getCompleted')->name('completed')->middleware('can:completed home help');
            Route::get('helps/dismiss', 'dismiss')->name('dismiss')->middleware('can:dismiss home help');
            Route::post('helps/dismiss', 'getDismiss')->name('dismiss')->middleware('can:dismiss home help');
            Route::get('helps/create', 'create')->name('create')->middleware('can:create home help');
            Route::get('{help}/show', 'show')->name('show')->middleware('can:view help');
        });
    Route::controller(SettingsController::class)
        ->prefix('settings')
        ->as('settings.')
        ->group(function (): void {
            Route::get('password', 'editPassword')->name('editPassword')->middleware('can:edit settings');
            Route::get('account', 'editAccount')->name('editAccount')->middleware('can:edit settings');
        });
    Route::controller(SearchController::class)
        ->prefix('search')
        ->as('search.')
        ->group(function (): void {
            Route::get('all', 'all')->name('all')->middleware('can:all search');
            Route::get('{search}/work', 'work')->name('work')->middleware('can:prefix search');
            Route::get('{search}/category', 'category')->name('category')->middleware('can:prefix search');
            Route::get('{search}/cabinet', 'cabinet')->name('cabinet')->middleware('can:prefix search');
        });
    Route::get('/stats', [StatisticController::class, 'index'])->name('stats')->middleware('can:view stats');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});
