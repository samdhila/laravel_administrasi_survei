<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::create([
            'name' => 'Jakarta',
            'population' => '900000',
        ]);

        City::create([
            'name' => 'Bandung',
            'population' => '800000',
        ]);

        City::create([
            'name' => 'Tangerang',
            'population' => '700000',
        ]);

        City::create([
            'name' => 'Yogyakarta',
            'population' => '600000',
        ]);

        City::create([
            'name' => 'Semarang',
            'population' => '500000',
        ]);

        City::create([
            'name' => 'Surabaya',
            'population' => '400000',
        ]);
    }
}
