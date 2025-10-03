<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepartmentRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $id = $this->route('department'); // null on create
        return [
            'name' => ['required','string','max:100', Rule::unique('departments','name')->ignore($id)],
            'code' => ['required','string','max:50',  Rule::unique('departments','code')->ignore($id)],
            'max_checkin_time'  => ['required','date_format:H:i'],
            'max_checkout_time' => ['required','date_format:H:i','after:max_checkin_time'],
        ];
    }
}
