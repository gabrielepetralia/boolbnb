<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\View;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ViewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i < 10000; $i++) {
          $new_view = new View();
          $new_view->ip_address = $faker->ipv4();
          date_default_timezone_set('Europe/Rome');
          $formattedDateTime = $faker->dateTimeInInterval('-6 month', '+6 month')->format('Y-m-d H:i:s');
          $new_view->date_time = $formattedDateTime;
          $new_view->new_view = rand(rand(0, 1),1);
          $new_view->apartment_id = Apartment::inRandomOrder()->first()->id;
          $new_view->save();
        }
    }
}
