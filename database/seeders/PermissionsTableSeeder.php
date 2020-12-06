<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => 'Admin']);
        $client =  Role::create(['name' => 'Client']);

     
        //Books
        Permission::create(['name' => 'view books']);
        Permission::create(['name' => 'update books']);
        Permission::create(['name' => 'create books']);
        Permission::create(['name' => 'delete books']);
        //Users
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'delete users']);
        //Loans
        Permission::create(['name' => 'view loans']);
        Permission::create(['name' => 'update loans']);
        Permission::create(['name' => 'create loans']);
        Permission::create(['name' => 'delete loans']);
        //Categories
        Permission::create(['name' => 'crud categories']);
        //Users
        Permission::create(['name' => 'crud users']);
        $admin->givePermissionTo([
        'crud users',
        'crud categories',
        'view books',
        'update books',
        'create books',
        'delete books',
        'view users',
        'update users',
        'create users',
        'delete users',
        'view loans',
        'update loans',
        'create loans',
        'delete loans'
        ]);

        $client->givePermissionTo([
        'view books',
        'view loans',
        'update loans',
        'create loans',]);

        $users = User::all();
        foreach ($users as $user) {
            if($user->role_id != null)
                $user->assignRole($user->role_id);
        }
    }
}
