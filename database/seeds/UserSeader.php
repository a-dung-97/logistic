<?php

use Illuminate\Database\Seeder;
use App\Role;
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

        ]);
        $role1 = Role::create([
            'name' => 'Role 1',
            'code' => 'role1',
        ]);
        $role2 = Role::create([
            'name' => 'Role 2',
            'code' => 'role2',
        ]);
        $role->users()->create([
            'name' => 'sysadmin',
            'username' => 'sysadmin',

            'email' => 'sysadmin@gmail.com',
            'phone_number' => '0833266699',
            'password' => Hash::make('12345678')
        ]);
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
