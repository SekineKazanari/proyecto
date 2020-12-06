<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "Admin";
        $user->email = "leche_canela@hotmail.com";
        $user->password = bcrypt("secret");
        $user->role_id = 1;
        $user->save();

        $user = new User();
        $user->name = "Client";
        $user->email = "canela_leche@hotmail.com";
        $user->password = bcrypt("secret");
        $user->role_id = 2;
        $user->save();
    }
}
