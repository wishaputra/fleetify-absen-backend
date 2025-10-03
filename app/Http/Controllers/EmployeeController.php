<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index()  { return Employee::with('department')->paginate(20); }
    public function store(EmployeeRequest $r) { return Employee::create($r->validated()); }
    public function show(Employee $employee) { return $employee->load('department'); }
    public function update(EmployeeRequest $r, Employee $employee) { $employee->update($r->validated()); return $employee->load('department'); }
    public function destroy(Employee $employee) { $employee->delete(); return response()->noContent(); }
}
