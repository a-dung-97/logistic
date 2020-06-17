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
            'home_url' => '/users'

        ]);
        $role1 = Role::create([
            'name' => 'Lái xe',
            'code' => 'LX',
        ]);
        $role2 = Role::create([
            'name' => 'Nhân viên kinh doanh',
            'code' => 'NVKD',
        ]);
        $role3 = Role::create([
            'name' => 'Nhân viên PSX',
            'code' => 'NVPSX',
        ]);
        $role4 = Role::create([
            'name' => 'Quản lý xe',
            'code' => 'QLX',
        ]);
        $role5 = Role::create([
            'name' => 'Nhân viên kho',
            'code' => 'NVK',
        ]);
        User::create([
            'name' => 'System Admin',
            'username' => 'sysadmin',
            'role_id' => 1,
            'email' => 'sysadmin@gmail.com',
            'phone_number' => '0833266697',
            'password' => Hash::make('12345678')
        ]);
        $role1->users()->create([
            'name' => 'LX 1',
            'username' => 'lx1',
            'email' => 'lx1@gmail.com',
            'phone_number' => '0961112381',
            'password' => Hash::make('12345678')
        ]);
        $role1->users()->create([
            'name' => 'LX 2',
            'username' => 'lx2',
            'email' => 'lx2@gmail.com',
            'phone_number' => '0961112382',
            'password' => Hash::make('12345678')
        ]);
        $role2->users()->create([
            'name' => 'NVKD 1',
            'username' => 'nvkd1',
            'email' => 'nvkd1@gmail.com',
            'phone_number' => '0961112383',
            'password' => Hash::make('12345678')
        ]);
        $role3->users()->create([
            'name' => 'NVPSX 1',
            'username' => 'nvpsx1',
            'email' => 'nvpsx1@gmail.com',
            'phone_number' => '0961112384',
            'password' => Hash::make('12345678')
        ]);
        $role4->users()->create([
            'name' => 'QLX 1',
            'username' => 'qlx1',
            'email' => 'qlx1@gmail.com',
            'phone_number' => '0961112385',
            'password' => Hash::make('12345678')
        ]);
        $role5->users()->create([
            'name' => 'QLK 1',
            'username' => 'qlk1',
            'email' => 'qlk1@gmail.com',
            'phone_number' => '0961112386',
            'password' => Hash::make('12345678')
        ]);
    }
}
