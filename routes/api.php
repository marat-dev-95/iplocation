<?php

use App\Http\Controllers\IpLocationController;
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

// for CRUD
Route::apiResource('iplocation', IpLocationController::class);
// for UI
Route::get('/getLocation', [IpLocationController::class, 'getLocation']);
