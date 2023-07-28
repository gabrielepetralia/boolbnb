<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Guest\PageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\Orders\OrderController;
use App\Http\Controllers\Admin\ApartmentController as AdminApartmentController;
use App\Http\Controllers\Admin\SponsorshipController;
use App\Http\Controllers\Api\ApartmentController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PageController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])
->name('admin.')
->prefix('admin')
->group(function () {
  // Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::resource('/sponsorships', SponsorshipController::class);
    Route::get('/user-auth', [UserController::class, 'index']);
    Route::resource('apartments', AdminApartmentController::class);
    Route::get('/{user_id}', [ApartmentController::class, 'getUserApartments']);
    Route::get('/apartment/{slug}', [ApartmentController::class, 'getApartmentDetail']);
    Route::post('/image',[ ImageController::class, 'store']);
    Route::post('/sponsorize/{apartmentId}/{sponsorshipId}', [AdminApartmentController::class, 'sponsorizeApartment'] );
    Route::get('/last-sponsorship/{apartmentId}', [AdminApartmentController::class, 'getLastActiveSponsorship']);
  });

  Route::post('/make-payment', [OrderController::class, 'makePayment']);
  Route::get('/generate-token', [OrderController::class, 'generate']);
require __DIR__ . '/auth.php';
require __DIR__ . '/api.php';

Route::get('{any?}', function () {
  return view('guest.home');
})->where('any', '.*')->name('homepage');
