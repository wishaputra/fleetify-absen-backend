<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::insert([
            ['name'=>'Engineering','code'=>'ENG','max_checkin_time'=>'09:00:00','max_checkout_time'=>'17:00:00'],
            ['name'=>'HR','code'=>'HR','max_checkin_time'=>'09:00:00','max_checkout_time'=>'17:00:00'],
        ]);
    }
}
