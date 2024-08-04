<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\hotelController;


Route::get('/hoteles',[hotelController::class, 'index']);

Route::get('/hoteles/{id}',[hotelController::class, 'show'] );

Route::post('/hoteles',[hotelController::class, 'store']);

Route::put('/hoteles/{id}',[hotelController::class, 'update']);

Route::patch('/hoteles/{id}',[hotelController::class, 'updatePartial']);

Route::delete('/hoteles/{id}', [hotelController::class, 'update']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
