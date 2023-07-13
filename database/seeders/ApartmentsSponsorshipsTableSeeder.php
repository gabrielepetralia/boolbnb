<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Sponsorship;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApartmentsSponsorshipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      for ($i = 0; $i < 100; $i++) {
        $apartment = Apartment::inRandomOrder()->first();

        $sponsorhip_id = Sponsorship::inRandomOrder()->first()->id;

        $apartment->sponsorships()->attach($sponsorhip_id);
      }
    }
}
