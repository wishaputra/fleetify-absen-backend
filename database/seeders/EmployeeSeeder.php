<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Department;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $eng = Department::where('code', 'ENG')->first();
        $hr  = Department::where('code', 'HR')->first();

        Employee::create([
            'employee_code' => 'EMP001',
            'name'          => 'Alice',
            'email'         => 'alice@example.com',
            'department_id' => $eng->id,
        ]);

        Employee::create([
            'employee_code' => 'EMP002',
            'name'          => 'Bob',
            'email'         => 'bob@example.com',
            'department_id' => $hr->id,
        ]);
    }
}
