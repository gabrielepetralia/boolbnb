<?php

use App\Http\Controllers\Api\ApartmentController;
use App\Http\Controllers\Api\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ViewController;



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
  Route::get('/{min_price}/{max_price}/{min_square_meters}/{min_bathrooms}/{min_beds}/{min_rooms}/{id}/{address}/{radiusInMeters}', [ApartmentController::class, 'getFilteredApartmentsWithServicesAndRadius']);
  Route::get('/{min_price}/{max_price}/{min_square_meters}/{min_bathrooms}/{min_beds}/{min_rooms}/{address}/{radiusInMeters}', [ApartmentController::class, 'getFilteredApartmentsWithoutServices']);
});

Route::resource('/message', MessageController::class);
Route::post('/view', [ViewController::class, 'store']);
Route::get('/view/{apartment_id}', [ViewController::class, 'index']);


