<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function store(Request $request){


      $new_image = new Image();
      $form_data = $request->all();
      if($request->hasFile('images')){
        $form_data['img_path'] ="/storage" . "/" . Storage::put('uploads', $form_data['images']);
        $new_image->fill($form_data);
        $new_image->save();



      }
      return response()->json($form_data);

    }
}
