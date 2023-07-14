<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Helpers\CustomHelper;
use App\Models\User;
use App\Models\Apartment;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;


class ApartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
      $types_of_structure = ['B&B','Villa','Residence'];
        for ($i=0; $i < 100; $i++) {
          $new_apartment = new Apartment();
          $new_apartment->title = $types_of_structure[rand(0, count($types_of_structure) - 1)] . " " . $faker->firstNameFemale();
          $new_apartment->slug = CustomHelper::generateUniqueSlug($new_apartment->title, new Apartment());
          $new_apartment->num_rooms = rand(1, 6);
          $new_apartment->num_beds = rand(1, 4);
          $new_apartment->num_bathrooms = rand(1, 3);
          $new_apartment->square_meters = rand(50, 300);
          $new_apartment->coordinates = DB::raw("ST_GeomFromText('POINT($faker->latitude $faker->longitude)')");
          $new_apartment->address = $faker->address();
          $new_apartment->visible = rand(0, 1);
          $new_apartment->user_id = User::inRandomOrder()->first()->id;
          $new_apartment->price = $faker->randomfloat(2, 10, 1000);

          $new_apartment->save();
        }
    }
}
