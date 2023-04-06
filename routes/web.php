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
Route::middleware('guest')->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('index');
    Route::post('login', [LoginController::class, 'login'])->name('login')->middleware('start.form')->middleware('throttle:10,10');
});

Route::middleware('auth')->group(function () {
    Route::middleware(['role:superAdmin'])->group(function () {
        Route::controller(HelpController::class)
        ->prefix('admin')
        ->as('help.')
        ->group(function () {
            Route::get('helps/all', 'index')->name('index');
            Route::post('helps/all', 'getIndex')->name('index');
            Route::get('helps/new', 'new')->name('new');
            Route::post('helps/new', 'getNew')->name('new');
        });
        Route::controller(CabinetController::class)
            ->prefix('admin/cabinet')
            ->as('cabinet.')
            ->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::get('{cabinet}/edit', 'edit')->name('edit');
            });
        Route::controller(CategoryController::class)
            ->prefix('admin/category')
            ->as('category.')
            ->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::get('{category}/edit', 'edit')->name('edit');
            });
        Route::controller(StatusController::class)
            ->prefix('admin/status')
            ->as('status.')
            ->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('{status}/edit', 'edit')->name('edit');
            });
        Route::controller(PriorityController::class)
            ->prefix('admin/priority')
            ->as('priority.')
            ->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::get('{priority}/show', 'show')->name('show');
                Route::get('{priority}/edit', 'edit')->name('edit');
            });
        Route::controller(UserController::class)
            ->prefix('admin/users')
            ->as('users.')
            ->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::get('{work}/show', 'show')->name('show');
                Route::get('{user}/edit', 'edit')->name('edit');
            });
    });
    Route::middleware(['role:admin|superAdmin'])->group(function () {
        Route::controller(HelpController::class)
        ->prefix('admin')
        ->as('help.')
        ->group(function () {
            Route::get('create', 'create')->name('create');
            Route::get('helps/dismiss', 'dismiss')->name('dismiss');
            Route::post('helps/dismiss', 'getDismiss')->name('dismiss');
            Route::get('{help}/edit', 'edit')->name('edit');
        });
        Route::controller(NewsController::class)
            ->prefix('news')
            ->as('news.')
            ->group(function () {
                Route::get('create', 'create')->name('create');
                Route::get('{news}/edit', 'edit')->name('edit');
            });
    });
    Route::middleware(['role:admin|superAdmin|manager'])->group(function () {
        Route::controller(HelpController::class)
        ->prefix('admin')
        ->as('help.')
        ->group(function () {
            Route::get('{help}/show', 'show')->name('show');
            Route::get('helps/worker', 'worker')->name('worker');
            Route::post('helps/worker', 'getWorker')->name('worker');
            Route::get('helps/completed', 'completed')->name('completed');
            Route::post('helps/completed', 'getCompleted')->name('completed');
        });
    });
    Route::middleware(['role:admin|superAdmin|manager|user'])->group(function () {
        Route::controller(HomeController::class)
            ->prefix('home')
            ->as('home.')
            ->group(function () {
                Route::get('helps/worker', 'worker')->name('worker');
                Route::post('helps/worker', 'getWorker')->name('worker');
                Route::get('helps/completed', 'completed')->name('completed');
                Route::post('helps/completed', 'getCompleted')->name('completed');
                Route::get('helps/dismiss', 'dismiss')->name('dismiss');
                Route::post('helps/dismiss', 'getDismiss')->name('dismiss');
                Route::get('helps/create', 'create')->name('create');
                Route::get('{help}/show', 'show')->name('show');
            });
            Route::controller(SettingsController::class)
            ->prefix('settings')
            ->as('settings.')
            ->group(function () {
                Route::get('edit', 'edit')->name('edit');
            });
        Route::controller(NewsController::class)
            ->prefix('news')
            ->as('news.')
            ->group(function () {
                Route::get('', 'index')->name('index');
                Route::get('{news}/show', 'show')->name('show');
            });
            Route::controller(SearchController::class)
            ->prefix('search')
            ->as('search.')
            ->group(function () {
                Route::get('all', 'all')->name('all');
                Route::get('{search}/work', 'work')->name('work');
                Route::get('{search}/category', 'category')->name('category');
                Route::get('{search}/cabinet', 'cabinet')->name('cabinet');
            });
        Route::get('/stats', [StatisticController::class, 'index'])->name('stats');
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    });
});
