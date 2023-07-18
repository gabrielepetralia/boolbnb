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
      $images = [
      "https://a0.muscache.com/im/pictures/40706270/81c0585d_original.jpg?im_w=720",
      "https://a0.muscache.com/im/pictures/e47c0a48-4f10-470d-aa86-66f79ae86f20.jpg?im_w=720",
      "https://a0.muscache.com/im/pictures/miso/Hosting-848341774182969784/original/057e6c1c-71d7-4733-9e9e-ad8d22175966.jpeg?im_w=720",
      "https://a0.muscache.com/im/pictures/575769db-5ee8-4bea-b79e-2b6e36b0c0bf.jpg?im_w=720",
      "https://a0.muscache.com/im/pictures/monet/Luxury-660649704045467259/original/eae9ba74-811e-41dd-965a-acb29d980bb5?im_w=720",
      "https://a0.muscache.com/im/pictures/d0a423de-e2a8-476e-ac73-68bb237b3464.jpg?im_w=720",
      "https://a0.muscache.com/im/pictures/03d1a59c-672d-4c10-80ec-3dce231fc643.jpg?im_w=720",
      "https://a0.muscache.com/im/pictures/14702bf4-7a16-4c57-a2f1-e9c3750a906d.jpg?im_w=720",
      "https://a0.muscache.com/im/pictures/miso/Hosting-50362228/original/e26507fb-2932-40c2-9c3b-f911e6968e27.jpeg?im_w=720",
      "https://a0.muscache.com/im/pictures/miso/Hosting-51113983/original/cc46a212-72d7-425f-9ac4-cc5d1531113f.jpeg?im_w=720"
      ];

      $types_of_structure = ['B&B','Villa','Residence'];
        for ($i=0; $i < 200; $i++) {
          $new_apartment = new Apartment();
          $new_apartment->title = $types_of_structure[rand(0, count($types_of_structure) - 1)] . " " . $faker->firstNameFemale();
          $new_apartment->slug = CustomHelper::generateUniqueSlug($new_apartment->title, new Apartment());
          $new_apartment->num_rooms = rand(1, 6);
          $new_apartment->num_beds = rand(1, 4);
          $new_apartment->num_bathrooms = rand(1, 3);
          $new_apartment->square_meters = rand(50, 300);
          $new_apartment->coordinates = DB::raw("ST_GeomFromText('POINT($faker->latitude $faker->longitude)')");
          $new_apartment->address = $faker->address();
          $new_apartment->description = $faker->text(500);
          $new_apartment->img_path = $images[rand(0, count($images) - 1)];
          $new_apartment->visible = rand(0, 1);
          $new_apartment->user_id = User::inRandomOrder()->first()->id;
          $new_apartment->price = $faker->randomfloat(2, 10, 1000);

          $new_apartment->save();
        }
    }
}
