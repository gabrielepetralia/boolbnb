<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use GuzzleHttp\Client;

class CustomHelper
{

  public static function generateUniqueSlug($str, $model)
  {
    $slug = Str::slug($str, '-');
    $original_slug = $slug;
    $slug_exixts = $model::where('slug', $slug)->first();
    $c = 1;
    while ($slug_exixts) {
      $slug = $original_slug . '-' . $c;
      $slug_exixts = $model::where('slug', $slug)->first();
      $c++;
    }
    return $slug;
  }

  public static function getCoordinates($request)
  {
      $client = new Client(['verify' => false]);

      try {
          $response = $client->get('https://api.tomtom.com/search/2/geocode/'. $request .'.json', [
              'query' => [
                  'view' => 'Unified',
                  'key' => 'BJn2pmnX1Y20KpKZAZYCLf4m1Gzqu2bG',
              ],
          ]);


          $data = json_decode($response->getBody()->getContents(), true);

          $latitude = $data['results'][0]['position']['lat'];
          $longitude = $data['results'][0]['position']['lon'];

          $coordinates = $latitude.' '.$longitude;

          return $coordinates;

          } catch (\Exception $e) {
            $errorMessage = $e->getMessage();

            return response()->json(['error' => $errorMessage], 500);
          }
  }

  public static function getCoordinatesForDistances($request)
  {
      $client = new Client(['verify' => false]);

      try {
          $response = $client->get('https://api.tomtom.com/search/2/geocode/'. $request .'.json', [
              'query' => [
                  'view' => 'Unified',
                  'key' => 'BJn2pmnX1Y20KpKZAZYCLf4m1Gzqu2bG',
              ],
          ]);


          $data = json_decode($response->getBody()->getContents(), true);

          $latitude = $data['results'][0]['position']['lat'];
          $longitude = $data['results'][0]['position']['lon'];

          $coordinates = $latitude.', '.$longitude;

          return $coordinates;

          } catch (\Exception $e) {
            $errorMessage = $e->getMessage();

            return response()->json(['error' => $errorMessage], 500);
          }
  }
}
