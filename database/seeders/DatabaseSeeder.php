<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Student;
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
        $this->call(GenderSeeder::class);
        $this->call(BlockSideRoomSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);

        AcademicYear::firstOrCreate([
            'name' => now()->year.'/'.now()->addYear()->year,
            'end_date' => now()->endOfYear()
        ]);

        Student::factory()->hasApplications(1)->count(2000)->create();

    }
}
