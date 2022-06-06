<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      if ($this->getUser('johndanielvalderama@gmail.com') == null) {
          $user = new User();
          $user->name = 'John Daniel Valderama';
          $user->email = 'johndanielvalderama@gmail.com';
          $user->password = bcrypt('@Password123');
          $user->email_verified_at = now();
          $user->created_at = now();
          $user->save();
      }
    }

    private function getUser($email){
      return User::where('email', $email)->first();
    }
}
