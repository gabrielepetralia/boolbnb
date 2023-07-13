<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment;
use App\Models\Service;

class ApartmentsServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $apartments = Apartment::all();
      $num_services = Service::all()->count();

      foreach($apartments as $apartment) {

        $services_ids = [];
        $rand = rand(2, $num_services);

        do {
          $service_id = Service::inRandomOrder()->first()->id;
          if(!in_array($service_id, $services_ids)) {
            array_push($services_ids, $service_id);
          }
        } while(count($services_ids) < $rand);

        for($i = 0; $i < count($services_ids); $i++) {
          $apartment->services()->attach($services_ids[$i]);
        }

      }
    }
}
