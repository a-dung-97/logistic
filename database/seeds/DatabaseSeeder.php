<?php

use App\TruckManufacturer;
use App\TruckType;
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
        $this->call(UserSeeder::class);
        $this->call(ActionSeeder::class);
        TruckManufacturer::create([
            'name' => 'Thaco',
            'code' => 'TC',

        ]);
        TruckManufacturer::create([
            'name' => 'Huyndai',
            'code' => 'HD',
        ]);
        TruckType::create([
            'name' => 'Xe tải 1 tấn',
            'code' => 'XT1',
            'tonnage' => 1

        ]);
        TruckType::create([
            'name' => 'Xe tải 3 tấn',
            'code' => 'XT3',
            'tonnage' => 3

        ]);
        TruckType::create([
            'name' => 'Xe tải 5 tấn',
            'code' => 'XT5',
            'tonnage' => 5

        ]);
        TruckType::create([
            'name' => 'Xe tải 7 tấn',
            'code' => 'XT7',
            'tonnage' => 7

        ]);
        TruckType::create([
            'name' => 'Xe tải 9 tấn',
            'code' => 'XT9',
            'tonnage' => 9

        ]);
    }
}
