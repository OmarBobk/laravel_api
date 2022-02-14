<?php

use Illuminate\Http\Request;
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

Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [\App\Http\Controllers\Auth\UserAuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Auth\UserAuthController::class, 'login']);

Route::apiResource('/employee', \App\Http\Controllers\EmployeeController::class)->middleware('auth:api');

