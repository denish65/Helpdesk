<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


Route::post("register",[AuthController::class,"apiRegister"]);


Route::post("login",[AuthController::class,"apiLogin"]);


Route::prefix("v1")->middleware("auth:sanctum")->group(function(){

Route::get("index",[AuthController::class,"index"]);

Route::post("logout",[AuthController::class,"apiLogout"]);








});
