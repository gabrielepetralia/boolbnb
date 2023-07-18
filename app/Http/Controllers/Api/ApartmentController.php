<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ApartmentController extends Controller
{
    public function getSponsorizedApartments() {
      // $apartments = Apartment::join('apartment_sponsorship', 'apartments.id', '=', 'apartment_sponsorship.apartment_id')
      //   ->whereNotNull('apartment_sponsorship.end_date')
      //   ->get();

      $apartments = [1,2,3];

      return response()->json(compact('apartments'));
    }

}
