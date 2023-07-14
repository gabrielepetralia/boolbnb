<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $users = config('users');
      foreach($users as $user) {

          $new_user = new User();

          $new_user->full_name = $user['full_name'];
          $new_user->email = $user['email'];
          $new_user->password = $user['password'];
          $new_user->birth_date = $user['birth_date'];

          $new_user->save();
      }
    }
}
