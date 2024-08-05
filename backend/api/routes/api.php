<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\TipoHabitacionesAcomodacionesController;


Route::get('/hoteles',[HotelController::class, 'index']);
Route::get('/hoteles/{id}',[HotelController::class, 'show'] );
Route::post('/hoteles',[HotelController::class, 'store']);
Route::put('/hoteles/{id}',[HotelController::class, 'update']);
Route::patch('/hoteles/{id}',[HotelController::class, 'updatePartial']);
Route::delete('/hoteles/{id}', [HotelController::class, 'destroy']);


Route::get('/tipo_habitaciones_acomodaciones', [TipoHabitacionesAcomodacionesController::class, 'index']);
Route::get('/tipo_habitaciones_acomodaciones/{id}', [TipoHabitacionesAcomodacionesController::class, 'show']);
Route::post('/tipo_habitaciones_acomodaciones', [TipoHabitacionesAcomodacionesController::class, 'store']);
Route::put('/tipo_habitaciones_acomodaciones/{id}', [TipoHabitacionesAcomodacionesController::class, 'update']);
Route::patch('/tipo_habitaciones_acomodaciones/{id}', [TipoHabitacionesAcomodacionesController::class, 'updatePartial']);
Route::delete('/tipo_habitaciones_acomodaciones/{id}', [TipoHabitacionesAcomodacionesController::class, 'destroy']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
