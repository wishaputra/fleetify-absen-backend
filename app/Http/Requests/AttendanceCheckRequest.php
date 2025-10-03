<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceCheckRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'employee_id' => ['required','exists:employees,id'],
            'timestamp'   => ['nullable','date'],
            'work_date'   => ['nullable','date'],
        ];
    }
}
