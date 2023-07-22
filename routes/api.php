<?php

use App\Http\Controllers\Api\ApartmentController;
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

Route::namespace('Api')
->prefix('api/apartments')
->group(function () {
  Route::get('/', [ApartmentController::class, 'getSponsorizedApartments']);
  Route::get('/apartment-detail/{slug}', [ApartmentController::class, 'getApartmentDetail']);
  Route::get('/{address}/{radius}', [ApartmentController::class, 'getApartmentFromPlaces']);
  Route::get('/services', [ApartmentController::class, 'getServices']);
});


