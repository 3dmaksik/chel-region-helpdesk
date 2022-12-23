<?php

use App\Http\Controllers\Api\HelpApiController;
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

Route::post('help/all', [HelpApiController::class, 'all']);
Route::get('sound_notify', [HelpApiController::class, 'getSoundNotify']);
