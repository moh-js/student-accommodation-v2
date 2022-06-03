<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'first_name' => 'Mohamed',
                'middle_name' => 'Juma',
                'last_name' => 'Said',
                'email' => 'madyrio100@gmail.com',
                'password' => bcrypt('madyrio@100'),
                'title' => 'Mr.',
                'role' => 'super-admin'
            ]
        ];

        foreach ($users as $user) {
            User::firstOrCreate(collect($user)->except('role')->toArray())->assignRole($user['role']);
        }
    }
}
