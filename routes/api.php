<?php

use App\Http\Controllers\Api\HelpApiController;
use App\Http\Controllers\Auth\AuthController;
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

Route::post('register', [AuthController::class, 'register']);
Route::get('login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('help/all', [HelpApiController::class, 'all']);
    //Route::post('profile', [AuthController::class, 'profile']);
    //Route::post('logout', [AuthController::class, 'logout']);
});
