<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SensorRestApi;
use App\Http\Controllers\Api\UserRestApi;

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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
  }); */

//SensorRestApi
Route::post("activate_sensor", [SensorRestApi::class, "index"])->name("activate_sensor");
Route::post("sensor_close", [SensorRestApi::class, "update"])->name("sensor_close");

//UserRestApi
Route::post("list_finger", [UserRestApi::class, "index"]);
Route::post("save_finger", [UserRestApi::class, "store"]);
Route::post("update_finger", [UserRestApi::class, "update"]);
Route::post("sincronizar", [UserRestApi::class, "sincronizar"]);

