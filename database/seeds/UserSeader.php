<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create([
            'name' => 'System Admin',
            'code' => 'sysadmin',
            'home_url'=>'/users'

        ]);
        $role1 = Role::create([
            'name' => 'Role 1',
            'code' => 'role1',
        ]);
        $role2 = Role::create([
            'name' => 'Role 2',
            'code' => 'role2',
        ]);
        User::create([
            'name' => 'System Admin',
            'username' => 'sysadmin',

            'email' => 'sysadmin@gmail.com',
            'phone_number' => '0833266699',
            'password' => Hash::make('12345678')
        ])->roles()->attach([1,2]);
        $role1->users()->create([
            'name' => 'User 1',
            'username' => 'role1',
            'email' => 'user1@gmail.com',
            'phone_number' => '0833266697',
            'password' => Hash::make('12345678')
        ]);
        $role2->users()->create([
            'name' => 'User 2',
            'username' => 'role2',

            'email' => 'user2@gmail.com',
            'phone_number' => '0833266698',
            'password' => Hash::make('12345678')
        ]);
    }
}
