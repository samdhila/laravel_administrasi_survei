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
            'name' => 'Toronto',
            'population' => '100000',
        ]);

        City::create([
            'name' => 'Vancouver',
            'population' => '100000',
        ]);

        City::create([
            'name' => 'Montreal',
            'population' => '100000',
        ]);

        City::create([
            'name' => 'Quebec',
            'population' => '100000',
        ]);

        City::create([
            'name' => 'Ottawa',
            'population' => '100000',
        ]);
    }
}
