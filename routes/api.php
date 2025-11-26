<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post("register",[AuthController::class, 'register']);
Route::post("login",[AuthController::class, 'login']);

Route::group(["middleware" => ['auth:sanctum']],function(){
    Route::apiResource("students",StudentController::class);
    Route::get('profile', [AuthController::class,'profile'])->name('profile');
    Route::post("logout",[AuthController::class, 'logout']);
});