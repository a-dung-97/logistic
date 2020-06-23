<?php

use App\Customer;
use App\Scrap;
use App\Truck;
use App\TruckManufacturer;
use App\TruckType;
use App\Warehouse;
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
        Scrap::create([
            'code' => 'PL1',
            'name' => 'PL1',
        ]);
        Scrap::create([
            'code' => 'PL2',
            'name' => 'PL2',
        ]);
        Scrap::create([
            'code' => 'PL3',
            'name' => 'PL3',
        ]);
        Customer::create([
            'code' => 'KH1',
            'name' => 'KH1'
        ])->scraps()->attach([1, 2, 3]);
        Customer::create([
            'code' => 'KH2',
            'name' => 'KH2'
        ])->scraps()->attach([1, 2, 3]);
        Customer::create([
            'code' => 'KH3',
            'name' => 'KH3'
        ])->scraps()->attach([1, 2, 3]);
        Truck::create([
            'number_plate' => '18B1-90620',
            'truck_manufacturer_id' => 1,
            'truck_type_id' => 2,
            'user_id' => 2,
        ]);
        Truck::create([
            'number_plate' => '18B1-99999',
            'truck_manufacturer_id' => 2,
            'truck_type_id' => 3,
            'user_id' => 3,
        ]);
        Warehouse::create([
            'name' => 'Kho 1',
            'code' => 'K1',
        ]);
        Warehouse::create([
            'name' => 'Kho 2',
            'code' => 'K2',
        ]);
    }
}
