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

Route::post('/register', [\App\Http\Controllers\Auth\UserAuthController::class, 'register'])->name('register');
Route::post('/login',    [\App\Http\Controllers\Auth\UserAuthController::class, 'login'])->name('login');
Route::post('/forgot',   [\App\Http\Controllers\ForgotController::class, 'forgot'])->name('forgot');
Route::post('/reset',   [\App\Http\Controllers\ForgotController::class, 'reset'])->name('reset');

Route::apiResource('/employee', \App\Http\Controllers\EmployeeController::class)->middleware('auth:api');

