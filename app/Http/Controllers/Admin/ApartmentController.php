<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApartmentRequest;
use App\Http\Requests\VisibilityCheck;
use App\Models\Apartment;
use Illuminate\Http\Request;
use App\Helpers\CustomHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

    $form_data['slug'] = CustomHelper::generateUniqueSlug($form_data['title'], new Apartment());
    $form_data['coordinates'] = DB::raw("ST_GeomFromText('POINT(" . CustomHelper::getCoordinates($form_data['address']) . ")')");
    $new_apartment = Apartment::create($form_data);
    // Da reindirizzare direttamente alla show
    return response()->json('ok');
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
    $form_data = $request->all();
    $apartment = Apartment::where('id', $id)->first();

    if($apartment->title !== $form_data['title']){
      $form_data['slug'] = CustomHelper::generateUniqueSlug($form_data['title'], new Apartment());
    }
    if($apartment->address !== $form_data['address']){
      $form_data['coordinates'] = DB::raw("ST_GeomFromText('POINT(" . CustomHelper::getCoordinates($form_data['address']) . ")')");
    }

    if(array_key_exists('image_path', $form_data)){

      if($apartment->image_path){
          Storage::disk('public')->delete($apartment->image_path);
      }

      $form_data['image_path'] = Storage::put('uploads', $form_data['image']);
  }

    $apartment->update($form_data);
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
    // if($apartment->image_path){
    //   Storage::disk('public')->delete($apartment->image_path);
    // }

    $apartment->delete();

  }


}
