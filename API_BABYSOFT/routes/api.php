<?php

use App\Http\Controllers\Auth\AuthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(["middleware" => ["auth:sanctum"]], function(){
  Route::get('/user', function (Request $request) {
      return $request->user();
  });

  Route::post('/logout', [AuthenticationController::class, 'logout']);
});

Route::post("/login", [AuthenticationController::class, 'login']);
Route::post("/register", [AuthenticationController::class, 'register']);