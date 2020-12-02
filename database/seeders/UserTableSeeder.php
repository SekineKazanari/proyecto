<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	$user = new User();
    	$user->name = "Nicole Perpuly";
    	$user->email = "leche_canela@hotmail.com";
    	$user->password = bcrypt("secret");
        $user->role_id = 1;
    	$user->save();

        $user = new User();
        $user->name = "Nico Perpuly";
        $user->email = "canela_leche@hotmail.com";
        $user->password = bcrypt("secret");
        $user->role_id = 2;
        $user->save();

        $user = new User();
        $user->name = "Nico Perpuly";
        $user->email = "sakari.26@hotmail.com";
        $user->password = bcrypt("secret");
        $user->role_id = 1;
        $user->save();
    }
}