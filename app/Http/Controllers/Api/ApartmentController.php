<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Image;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\CustomHelper;
use Illuminate\Database\Eloquent\Builder;




class ApartmentController extends Controller
{
  // Get all apartments with a sposorization going on
  public function getSponsorizedApartments()
  {
    date_default_timezone_set('Europe/Rome');
    $current_date = date('Y-m-d H:i:s');

    $apartments = Apartment::join('apartment_sponsorship', 'apartments.id', '=', 'apartment_sponsorship.apartment_id')
        ->where('apartment_sponsorship.start_date', '<=', $current_date)
        ->where('apartment_sponsorship.end_date', '>=', $current_date)
        ->where('apartments.visible', '=', 1)
        ->select('apartments.*')
        ->get()
        ->makeHidden('coordinates');

    return response()->json(compact('apartments'));
  }

  // get all apartments of a user
  public function getUserApartments($user_id)
  {
    $apartments = Apartment::with('messages')->where('user_id', $user_id)->orderBy('id', 'desc')->get()->makeHidden('coordinates');
    return response()->json(compact('apartments'));
  }

  // get apartment from slug
  public function getApartmentDetail($slug)
  {
    $apartment = Apartment::where('slug', $slug)->with('services')->get()->makeHidden('coordinates');
    $gallery = Image::where('apartment_id', $apartment[0]->id)->get();
    return response()->json(compact('apartment', 'gallery'));
  }

  // get all services available
  public function getServices()
  {
    $services = Service::all();

    return response()->json(compact("services"));
  }

  // get apartment in a certain radius
  public function getApartmentFromPlaces($address, $radiusInMeters)
  {
    $coordinates = CustomHelper::getCoordinatesForDistances($address);
    $apartments = Apartment::select('*')->selectRaw("
        ST_X(coordinates) AS lat,
        ST_Y(coordinates) AS lng,
        ST_DISTANCE(
            coordinates,
            POINT($coordinates)
        ) / 1000 AS distance_in_km
    ")
    ->whereRaw("ST_DISTANCE(coordinates, POINT($coordinates)) <= $radiusInMeters")
    ->where('apartments.visible', '=', 1)
    ->get()->makeHidden('coordinates');

    return response()->json(compact('apartments'));
  }

  // Get filtered apartments with services and radius
  public function getFilteredApartmentsWithServicesAndRadius($min_price, $max_price, $min_square_meters, $min_bathrooms, $min_beds, $min_rooms, $id, $address ,$radiusInMeters){
    $coordinates = CustomHelper::getCoordinatesForDistances($address);
    $apartments = Apartment::select('*')->selectRaw("
                  ST_X(coordinates) AS lat,
                  ST_Y(coordinates) AS lng,
                  ST_DISTANCE(
                      coordinates,
                      POINT($coordinates)
                      ) / 1000 AS distance_in_km
                      ")
                ->whereRaw("ST_DISTANCE(coordinates, POINT($coordinates)) <= $radiusInMeters")
                ->with('services')
                ->where('price', '>=', $min_price)
                ->where('price', '<=', $max_price)
                ->where('square_meters', '>=', $min_square_meters)
                ->where('num_rooms', '>=', $min_rooms)
                ->where('num_beds', '>=', $min_beds)
                ->where('num_bathrooms', '>=', $min_bathrooms)
                ->where('apartments.visible', '=', 1)
                ->whereHas('services', function(Builder $query) use($id){
                  $query->where('service_id', $id);
               })
                ->get()->makeHidden('coordinates');

    return response()->json(compact('apartments'));

  }

  // Get filtered apartments with services and radius
  public function getFilteredApartmentsWithoutServices($min_price, $max_price, $min_square_meters, $min_bathrooms, $min_beds, $min_rooms, $address ,$radiusInMeters){
    $coordinates = CustomHelper::getCoordinatesForDistances($address);
    $apartments = Apartment::select('*')->selectRaw("
                  ST_X(coordinates) AS lat,
                  ST_Y(coordinates) AS lng,
                  ST_DISTANCE(
                      coordinates,
                      POINT($coordinates)
                      ) / 1000 AS distance_in_km
                      ")
                ->whereRaw("ST_DISTANCE(coordinates, POINT($coordinates)) <= $radiusInMeters")
                ->where('price', '>=', $min_price)
                ->where('price', '<=', $max_price)
                ->where('square_meters', '>=', $min_square_meters)
                ->where('num_rooms', '>=', $min_rooms)
                ->where('num_beds', '>=', $min_beds)
                ->where('num_bathrooms', '>=', $min_bathrooms)
                ->where('apartments.visible', '=', 1)
                ->get()->makeHidden('coordinates');

    return response()->json(compact('apartments'));

  }

}
