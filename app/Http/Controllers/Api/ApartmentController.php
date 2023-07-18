<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
  public function getSponsorizedApartments()
  {
    date_default_timezone_set('Europe/Rome');
    $current_date = date('Y-m-d H:i:s');

    $apartments = Apartment::join('apartment_sponsorship', 'apartments.id', '=', 'apartment_sponsorship.apartment_id')
        ->where('apartment_sponsorship.start_date', '<=', $current_date)
        ->where('apartment_sponsorship.end_date', '>=', $current_date)
        ->select('apartments.*')
        ->get()
        ->makeHidden('coordinates');

    return response()->json(compact('apartments'));
  }
}
