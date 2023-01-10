<?php

use App\Http\Controllers\Api\UserController;
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
Route::post('/register',[UserController::class,"register"]);
Route::post('/login',[UserController::class,"login"]);

//Para acceder a estas rutas debemos tener un token de autenticacion
Route::group(['middleware'=>["auth:sanctum"]],function(){
    //Rutas
    Route::get("user-profile",[UserController::class,'userProfile']);
    Route::get("logout",[UserController::class,'logout']);
});

