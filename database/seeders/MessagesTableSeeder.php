<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Message;
use App\Models\Apartment;


class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i < 300; $i++) {
          $new_message = new Message();
          $new_message->email =  $faker->email();
          $new_message->name = $faker->name();
          $new_message->msg_text =  $faker->text(100);

          date_default_timezone_set('Europe/Rome');
          $formattedDateTime = $faker->dateTimeInInterval('-1 month', '+1 month')->format('Y-m-d');
          $new_message->sent_date = $formattedDateTime;
          $new_message->apartment_id = Apartment::inRandomOrder()->first()->id;
          $new_message->save();
        }
    }
}
