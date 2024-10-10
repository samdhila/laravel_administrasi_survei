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
            'email' => 'admin@survey.com',
            'password' => bcrypt('1234'),
        ]);
        $admin->assignRole('admin');

        $admin = User::create([
            'name' => 'Alpha',
            'email' => 'alpha@survey.com',
            'password' => bcrypt('1234'),
        ]);
        $admin->assignRole('admin');

        $user = User::create([
            'name' => 'Agus',
            'email' => 'agus@survey.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('user');

        $user = User::create([
            'name' => 'Bella',
            'email' => 'bella@survey.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('user');

        $user = User::create([
            'name' => 'Candra',
            'email' => 'candra@survey.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('user');

        $user = User::create([
            'name' => 'Dimas',
            'email' => 'dimas@survey.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('user');

        $user = User::create([
            'name' => 'Erika',
            'email' => 'erika@survey.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('user');

        $user = User::create([
            'name' => 'Farhan',
            'email' => 'farhan@survey.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('user');
    }
}
