<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // panggil seeder lain di sini
        $this->call([
            DepartmentSeeder::class,
            EmployeeSeeder::class,
        ]);
    }
}
