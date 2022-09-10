<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@dataset.com',
            'password' => bcrypt('1234'),
        ]);

        $admin->assignRole('admin');

        $admin = User::create([
            'name' => 'Alpha',
            'email' => 'alpha@dataset.com',
            'password' => bcrypt('1234'),
        ]);

        $admin->assignRole('admin');

        $user = User::create([
            'name' => 'Beta',
            'email' => 'beta@dataset.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole('user');

        $user = User::create([
            'name' => 'Charlie',
            'email' => 'charlie@dataset.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole('user');

        $user = User::create([
            'name' => 'Delta',
            'email' => 'delta@dataset.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole('user');

        $user = User::create([
            'name' => 'Edison',
            'email' => 'edison@dataset.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole('user');

        $user = User::create([
            'name' => 'Foxrot',
            'email' => 'foxrot@dataset.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole('user');
    }
}
