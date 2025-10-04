<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DepartementController extends Controller
{
    public function index()
    {
        return Departement::orderBy('departement_name')->paginate(20);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'departement_name'   => ['required','string','max:255', Rule::unique('departement','departement_name')],
            'max_clock_in_time'  => ['required','date_format:H:i'],
            'max_clock_out_time' => ['required','date_format:H:i','after:max_clock_in_time'],
        ]);
        return Departement::create($data);
    }

    public function show(Departement $department)
    {
        return $department;
    }

    public function update(Request $r, Departement $department)
    {
        $data = $r->validate([
            'departement_name'   => ['required','string','max:255', Rule::unique('departement','departement_name')->ignore($department->id)],
            'max_clock_in_time'  => ['required','date_format:H:i'],
            'max_clock_out_time' => ['required','date_format:H:i','after:max_clock_in_time'],
        ]);
        $department->update($data);
        return $department;
    }

    public function destroy(Departement $department)
    {
        $department->delete();
        return response()->noContent();
    }
}
