<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
  public function run()
  {
    $this->call([
      UsersTableSeeder::class, //to remove
      ServicesTableSeeder::class,
      SponsorshipsTableSeeder::class,
      ApartmentsTableSeeder::class, //to remove
      ApartmentsServicesTableSeeder::class, //to remove
      ApartmentsSponsorshipsTableSeeder::class, //to remove
      MessagesTableSeeder::class,
      ViewsTableSeeder::class

    ]);
  }
}
