<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Departement;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('attendance_history')->truncate(); // jika ada FK logis ke departement via employee, aman2 saja karena bukan FK SQL
        DB::table('attendance')->truncate();
        DB::table('employee')->truncate();
        DB::table('departement')->truncate();
        Schema::enableForeignKeyConstraints();

        Departement::insert([
            ['departement_name'=>'Engineering','max_clock_in_time'=>'09:00:00','max_clock_out_time'=>'17:00:00','created_at'=>now(),'updated_at'=>now()],
            ['departement_name'=>'HR','max_clock_in_time'=>'09:00:00','max_clock_out_time'=>'17:00:00','created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
