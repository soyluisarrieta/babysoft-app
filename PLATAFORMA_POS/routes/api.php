<?php

use App\Http\Controllers\Auth\AuthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(["middleware" => ["auth:sanctum"]], function(){
  Route::get('/user', function (Request $request) {
      return $request->user();
  });

  Route::post('/logout', [AuthenticationController::class, 'logout']);
});

Route::post("/login", [AuthenticationController::class, 'login']);
Route::post("/register", [AuthenticationController::class, 'register']);
