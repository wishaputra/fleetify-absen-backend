<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $id = $this->route('employee');
        return [
            'employee_code' => ['required','max:50', Rule::unique('employees','employee_code')->ignore($id)],
            'name'          => ['required','max:100'],
            'email'         => ['required','email', Rule::unique('employees','email')->ignore($id)],
            'department_id' => ['required','exists:departments,id'],
        ];
    }
}
