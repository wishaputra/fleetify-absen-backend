<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceHistory extends Model
{
    protected $table = 'attendance_history';

    protected $fillable = [
        'employee_id',     // varchar(50)
        'attendance_id',   // string(100)
        'date_attendance',
        'attendance_type', // 1 = in, 2 = out
        'description',
    ];
}
