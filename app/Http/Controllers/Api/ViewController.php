<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\View;
use Illuminate\Support\Facades\DB;
class ViewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($apartment_id)
    {
        $visuals = View::select(
          DB::raw('MONTHNAME(date_time) AS mese'),
          DB::raw('COUNT(*) AS num_views')
      )
      ->where('apartment_id', $apartment_id)
      ->groupBy(DB::raw('MONTHNAME(date_time)'))
      ->get();

      $total_views = View::where('apartment_id', $apartment_id)->count();
      $new_views = View::where('apartment_id', $apartment_id)->where('new_view', 1)->count();
        // ->selectRaw('
        // SELECT MONTHNAME(date_time) AS mese, COUNT(*) AS numero_record
        // FROM `views`
        // WHERE apartment_id =' . $apartment_id . '
        // GROUP BY MONTHNAME(date_time);');

        return response()->json(compact('visuals', 'total_views', 'new_views'));
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
    public function store(Request $request)
    {
      date_default_timezone_set('Europe/Rome');
      $form_data = $request->all();
      $form_data['date_time'] = date('Y-m-d H:i');
      $count = View::where('ip_address', $form_data['ip_address'])->where('apartment_id', $form_data['apartment_id'])->count();
      if($count > 0){
        $form_data['new_view'] = 0;
      }


      $new_view = new View();
      $new_view::create($form_data);
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
        //
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
