<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApartmentRequest;
use App\Http\Requests\VisibilityCheck;
use App\Models\Apartment;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use App\Helpers\CustomHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class ApartmentController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */


  public function index()
  {

  }

  public function sponsorizeApartment($apartmentId, $sponsorshipId){

    date_default_timezone_set('Europe/Rome');

    $duration = Sponsorship::where('id', $sponsorshipId)->value('duration');

    $apartment = Apartment::where('id', $apartmentId)->first();

    $end_dates = DB::table('apartment_sponsorship')
      ->select('end_date')
      ->where('apartment_id', $apartmentId)
      ->get();


    if(count($end_dates) > 0) {
      $lastEndDate = $end_dates[0]->end_date;

      foreach ($end_dates as $end_date) {
        if($end_date->end_date > $lastEndDate)
        {
          $lastEndDate = $end_date->end_date;
        }
      }

      if($lastEndDate > date('Y-m-d H:i:s')) {
        $start_date = $lastEndDate;
      } else {
        $start_date = date('Y-m-d H:i:s');
      }
    } else {
      $start_date = date('Y-m-d H:i:s');
    }

    $end_date = date('Y-m-d H:i:s', strtotime($start_date . ' +' . $duration . ' hours'));

    $apartment->sponsorships()->attach($sponsorshipId, [
      'start_date' => $start_date,
      'end_date' => $end_date

    ]);
  }

  public function getLastActiveSponsorship($slug) {
    date_default_timezone_set('Europe/Rome');

    $curr_date = date('Y-m-d H:i:s');

    $apartmentId = Apartment::where('slug', $slug)->pluck('id')->first();

    $last_end_date = DB::table('apartment_sponsorship')
    ->where('apartment_id', $apartmentId)
    ->max('end_date');

    if($last_end_date > $curr_date) {
      $str =  $last_end_date;
    } else {
      $str = 'Non attiva';
    }

    return response()->json($str);
  }


  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(ApartmentRequest $request)
  {

    $form_data = $request->all();

    // if(in_array('visible', $form_data)){
    //   $form_data = $visiblecheck->all();
    // }
    $form_data['visible'] = ($request->visible == "true") ? 1 : 0;
    $form_data['slug'] = CustomHelper::generateUniqueSlug($form_data['title'], new Apartment());
    $form_data['coordinates'] = DB::raw("ST_GeomFromText('POINT(" . CustomHelper::getCoordinates($request->input('address')) . ")')");

    if($request->hasFile('image')){

      $form_data['img_path'] ="/storage" . "/" . Storage::put('uploads', $form_data['image']);
    }

    $new_apartment = Apartment::create($form_data);


  $services = json_decode($request->input('services'), true);
  if($request->input('services')){
    $new_apartment->services()->attach($services);

  }

    return response()->json($form_data);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {


    $apartment = Apartment::where('id', $id)->first();


    $form_data = $request->all();

    $form_data['visible'] = ($request->visible == "true") ? 1 : 0;


    if($request->hasFile('image')){
    if($request->image){
      $form_data['img_path'] ="/storage" . "/" . Storage::put('uploads', $request->image);
    }
  }

    if($apartment->title !== $form_data['title']){
      $form_data['slug'] = CustomHelper::generateUniqueSlug($form_data['title'], new Apartment());
    }
    if($apartment->address !== $form_data['address']){
      $form_data['coordinates'] = DB::raw("ST_GeomFromText('POINT(" . CustomHelper::getCoordinates($form_data['address']) . ")')");
    }


    $services = json_decode($request->input('services'), true);
    if($request->input('services')){
        $apartment->services()->sync($services);
    }else {
        $apartment->services()->detach();
    }

  $apartment->update($form_data);;

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $apartment = Apartment::where('id', $id)->first();
    if($apartment->image_path){
      Storage::disk('public')->delete($apartment->image_path);
    }

    $apartment->delete();
  }


}
