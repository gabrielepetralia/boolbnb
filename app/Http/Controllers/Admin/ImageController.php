<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modals\Image;
use Illuminate\Support\Facades\Storage;


class ImageController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $form_data = $request->all();
      if($request->input('images')){
        $imageNames = explode(',', $request->input('images'));


        foreach($imageNames as $image){
          $form_data['apartment_id'] = $request->apartment_id;
          $file = $request->file($image);
          $form_data['image_path'] = "/storage/uploads" . "/" . $file->move(public_path('uploads'), $file) ;

          $newImage = Image::create($form_data);
        }
        return response()->json('Immagini salvate correttamente');
      }

      return response()->json( $form_data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
