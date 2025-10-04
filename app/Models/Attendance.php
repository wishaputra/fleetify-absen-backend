<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendance';

    protected $fillable = [
        'employee_id',     // varchar(50) -> employee.employee_id
        'attendance_id',   // string(100), unique
        'clock_in',
        'clock_out',
    ];

    // relasi berbasis "kode" karyawan (string), bukan PK 'id'
    public function employeeByCode()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }
}
