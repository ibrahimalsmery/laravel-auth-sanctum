<?php

use App\Http\Controllers\api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return ['info' => 'api server'];
});
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// request need this header  { "Authorization" : "Bearer <token>" }
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::match(['post', 'get'], 'user', function (Request $request) {
        return $request->user();
    });
});
