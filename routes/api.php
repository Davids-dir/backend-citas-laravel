<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas de usuario CRUD
Route::apiResource ('user', UserController::class);
Route::post ('/user/login', [UserController::class, 'login']) -> name ('login');
Route::get ('/user/logout', [UserController::class, 'logout']) -> name ('logout');

// Endpoint de citas de usuarios protegida mediante 'Auth'
Route::apiResource('appointment', AppointmentController::class);