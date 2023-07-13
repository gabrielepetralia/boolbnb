<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Helpers\CustomHelper;
use App\Models\Service;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $services = config('services_seeder');

      foreach ($services as $service) {
        $new_service = new Service();

        $new_service->name = $service['name'];
        $new_service->slug = CustomHelper::generateUniqueSlug($new_service->name, new Service());

        $new_service->save();
      }
    }
}
