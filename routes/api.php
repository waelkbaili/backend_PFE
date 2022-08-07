<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\LivetripController;
use App\Http\Controllers\TripdataController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\NewPasswordController;


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

Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class,'register']);
    Route::post('/login', [AuthController::class,'login']);
    Route::get('/users/{id}', [AuthController::class,'show']);
    Route::get('/position/{user_id}', [TripdataController::class,'last']);
    Route::get('/getcar/{user_id}', [CarController::class,'show']);
    Route::get('/showtrip/{vin}', [TripController::class,'getListTripByVin']);
    Route::get('/showLiveTrip/{user_id}', [LivetripController::class,'findLiveTrip']);
    Route::post('/showtrip', [TripController::class,'showListTrip']);
    Route::post('/position', [TripdataController::class,'getPosition']);
    Route::post('/liveposition', [TripdataController::class,'getLastPosition']);
    //Route::post('/forgot-password', [NewPasswordController::class,'forgotPassword']);
    //Route::post('/reset-password', [NewPasswordController::class, 'reset']);
    Route::post('/addtripdata', [TripdataController::class,'store']);
});



Route::group(['prefix' => 'v1','middleware'=>['auth:sanctum']],function () {
    Route::post('/logout', [AuthController::class,'logout']);
    Route::post('/addcar', [CarController::class,'store']);
    Route::post('/addlivetrip', [LivetripController::class,'store']);
    Route::post('/addtrip', [TripController::class,'store']);
    Route::put('/update/{id}', [AuthController::class,'update']);
    Route::delete('/deletecar', [CarController::class,'destroyByVIN']);
    Route::delete('/deletelivetrip/{user_id}', [LivetripController::class,'destroy']);
});


