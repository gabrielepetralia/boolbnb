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
      $addresses = config('addresses');

      $images = [
      "https://a0.muscache.com/im/pictures/40706270/81c0585d_original.jpg?im_w=720",
      "https://a0.muscache.com/im/pictures/e47c0a48-4f10-470d-aa86-66f79ae86f20.jpg?im_w=720",
      "https://a0.muscache.com/im/pictures/miso/Hosting-848341774182969784/original/057e6c1c-71d7-4733-9e9e-ad8d22175966.jpeg?im_w=720",
      "https://a0.muscache.com/im/pictures/575769db-5ee8-4bea-b79e-2b6e36b0c0bf.jpg?im_w=720",
      "https://a0.muscache.com/im/pictures/monet/Luxury-660649704045467259/original/eae9ba74-811e-41dd-965a-acb29d980bb5?im_w=720",
      "https://a0.muscache.com/im/pictures/d0a423de-e2a8-476e-ac73-68bb237b3464.jpg?im_w=720",
      "https://a0.muscache.com/im/pictures/03d1a59c-672d-4c10-80ec-3dce231fc643.jpg?im_w=720",
      "https://a0.muscache.com/im/pictures/miso/Hosting-50362228/original/e26507fb-2932-40c2-9c3b-f911e6968e27.jpeg?im_w=720",
      "https://a0.muscache.com/im/pictures/miso/Hosting-51113983/original/cc46a212-72d7-425f-9ac4-cc5d1531113f.jpeg?im_w=720",
      "https://a0.muscache.com/im/pictures/miso/Hosting-777810924494262448/original/323b2bd5-c5f3-49a4-bd3e-c04e35021c65.jpeg?im_w=720",
      "https://a0.muscache.com/im/pictures/miso/Hosting-768081138982559324/original/0d7d9cc8-5ec5-4400-afec-c2bd0108ce5e.jpeg?im_w=720",
      "https://a0.muscache.com/im/pictures/miso/Hosting-751335671048162395/original/f74e3a33-2a0d-4f8a-813d-e663a59139c6.jpeg?im_w=720",
      "https://a0.muscache.com/im/pictures/miso/Hosting-822489409834838561/original/5913a689-76a3-466a-ab6e-1c32c87b61d2.jpeg?im_w=720",
      "https://a0.muscache.com/im/pictures/monet/Luxury-729733627920512482/original/3027954e-7a6c-4818-b08b-599640529416?im_w=720",
      "https://a0.muscache.com/im/pictures/7fd995eb-b829-4356-9d0a-2da308e7d483.jpg?im_w=720",
      "https://a0.muscache.com/im/pictures/miso/Hosting-852385091310392914/original/c4670428-bddd-4897-8ce2-4cf335bd0469.jpeg?im_w=720",
      "https://a0.muscache.com/im/pictures/miso/Hosting-929065902902226079/original/c8609343-d6bd-4fad-b7ed-8c250491647f.jpeg?im_w=720",
      "https://a0.muscache.com/im/pictures/miso/Hosting-874686035326211853/original/ce3819b6-38cc-43b7-98b1-d0583a999752.jpeg?im_w=720",
      "https://a0.muscache.com/im/pictures/miso/Hosting-892636584500492829/original/c45bf8cf-2ad6-4930-8c9f-f6f3c992aedd.jpeg?im_w=720",
      "https://a0.muscache.com/im/pictures/488642f5-bbe3-46e5-a86c-9f053036daa2.jpg?im_w=720",
      "https://a0.muscache.com/im/pictures/a765f678-3591-41d8-b6f8-1b2f49d4789f.jpg?im_w=720",
      "https://a0.muscache.com/im/pictures/4496e003-3e4f-4b5e-8faf-f8bbb78a2e76.jpg?im_w=720",
      "https://a0.muscache.com/im/pictures/airflow/Hosting-573795977090488084/original/c4bd4963-86d1-44ba-aea7-7c5738891305.jpg?im_w=720",
      "https://a0.muscache.com/im/pictures/e5d21231-4a4d-4047-955c-cbe9a4c35c80.jpg?im_w=720",
      "https://a0.muscache.com/im/pictures/b7c9264d-73c9-45c3-882e-6e9577d63d68.jpg?im_w=720",
      "https://a0.muscache.com/im/pictures/miso/Hosting-651115237829300826/original/3a7f8608-f9ca-464c-a352-f0f5281b4b14.jpeg?im_w=720",
      "https://a0.muscache.com/im/pictures/1f6c495e-b877-4a48-9f2c-d8012f640166.jpg?im_w=720",
      "https://a0.muscache.com/im/pictures/2d8fd134-8d7c-4b69-a37e-17558908c426.jpg?im_w=720",
      "https://a0.muscache.com/im/pictures/miso/Hosting-51542883/original/69582a07-0538-459d-88f5-641f1e240c9e.jpeg?im_w=720",
      "https://a0.muscache.com/im/pictures/miso/Hosting-23531345/original/c265ecaa-e644-4e9f-b7c6-30dce7f36a57.jpeg?im_w=720",
      "https://a0.muscache.com/im/pictures/fc7542b1-a0c9-4f36-9ad3-75e2eeb615f3.jpg?im_w=720",
      "https://a0.muscache.com/im/pictures/miso/Hosting-883148776685755511/original/dd4d6b6d-dd83-4e3a-94bd-6047a860966f.jpeg?im_w=720"
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
          $new_apartment->address = $addresses[rand(0, count($addresses) -1)]['via_completa'];
          $new_apartment->coordinates =  DB::raw("ST_GeomFromText('POINT(" . CustomHelper::getCoordinates($new_apartment->address) . ")')");
          $new_apartment->description = $faker->text(500);
          $new_apartment->img_path = $images[rand(0, count($images) - 1)];
          $new_apartment->visible = rand(0, 1);
          $new_apartment->user_id = User::inRandomOrder()->first()->id;
          $new_apartment->price = $faker->randomfloat(2, 10, 1000);

          $new_apartment->save();
        }
    }
}
