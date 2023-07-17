<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Sponsorship;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ApartmentsSponsorshipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
      for ($i = 0; $i < 100; $i++) {
        $sponsorships = Sponsorship::all();

        $apartment = Apartment::inRandomOrder()->first();
        $sponsorhip_id = Sponsorship::inRandomOrder()->first()->id;

        $duration = Sponsorship::where('id', $sponsorhip_id)->value('duration');

        $start_date = $faker->date() . " " . $faker->time();
        $end_date = rand(0, 1) ? date('Y-m-d H:i:s', strtotime($start_date . ' +' . $duration . ' hours')) : null;

        $apartment->sponsorships()->attach($sponsorhip_id, [
          'start_date' => $start_date,
          'end_date' => $end_date
        ]);
      }
    }
}
