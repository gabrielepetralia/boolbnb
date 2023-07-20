<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\CustomHelper;



class ApartmentController extends Controller
{
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

  public function getUserApartments($user_id)
  {

    $apartments = Apartment::where('user_id', $user_id)->get()->makeHidden('coordinates');
    $coordinates = DB::table('apartments')
        ->selectRaw("ST_X(coordinates) as lat, ST_Y(coordinates) as lng")
        ->where('user_id', $user_id)
        ->first();
    return response()->json(compact('apartments', 'coordinates'));
  }

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
    ->get()->makeHidden('coordinates');

    return response()->json(compact('apartments'));
  }

}
