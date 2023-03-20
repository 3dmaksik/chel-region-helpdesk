<?php

use App\Http\Controllers\Api\HelpApiController;
use App\Http\Controllers\Api\WorkApiController;
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

Route::post('help/all', [HelpApiController::class, 'getAllPages']);
Route::get('help/new', [HelpApiController::class, 'newPagesCount']);
Route::get('help/now', [HelpApiController::class, 'nowPagesCount']);
Route::get('work/all', [WorkApiController::class, 'work']);
