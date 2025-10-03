<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index()  { return Department::paginate(20); }
    public function store(DepartmentRequest $r) { return Department::create($r->validated()); }
    public function show(Department $department) { return $department; }
    public function update(DepartmentRequest $r, Department $department) { $department->update($r->validated()); return $department; }
    public function destroy(Department $department) { $department->delete(); return response()->noContent(); }
}
