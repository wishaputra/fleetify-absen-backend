<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;     // <-- tambah
use App\Models\Departement;  // <-- tambah

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $eng = Departement::where('departement_name', 'Engineering')->first();
        $hr  = Departement::where('departement_name', 'HR')->first();

        Employee::create([
            'employee_id'    => 'EMP001',
            'name'           => 'Alice',
            'email'          => 'alice@example.com',
            'address'        => 'Jakarta',
            'departement_id' => $eng?->id,   // safe operator
        ]);

        Employee::create([
            'employee_id'    => 'EMP002',
            'name'           => 'Bob',
            'email'          => 'bob@example.com',
            'address'        => 'Bandung',
            'departement_id' => $hr?->id,
        ]);
    }
}
