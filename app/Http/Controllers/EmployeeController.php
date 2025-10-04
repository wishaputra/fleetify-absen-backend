<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index()
    {
        return Employee::with('departement')->orderBy('name')->paginate(20);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'employee_id'   => ['required','string','max:50', Rule::unique('employee','employee_id')],
            'name'          => ['required','string','max:255'],
            'email'         => ['nullable','email', Rule::unique('employee','email')],
            'address'       => ['nullable','string'],
            'departement_id'=> ['required','exists:departement,id'],
        ]);
        return Employee::create($data);
    }

    public function show(Employee $employee)
    {
        return $employee->load('departement');
    }

    public function update(Request $r, Employee $employee)
    {
        $data = $r->validate([
            'employee_id'   => ['required','string','max:50', Rule::unique('employee','employee_id')->ignore($employee->id)],
            'name'          => ['required','string','max:255'],
            'email'         => ['nullable','email', Rule::unique('employee','email')->ignore($employee->id)],
            'address'       => ['nullable','string'],
            'departement_id'=> ['required','exists:departement,id'],
        ]);
        $employee->update($data);
        return $employee->load('departement');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->noContent();
    }
}
