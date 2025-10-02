<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model {
    protected $fillable = ['employee_id','work_date','check_in_at','check_out_at','status_in','status_out','late_minutes','early_leave_minutes'];
    protected $casts = ['work_date'=>'date','check_in_at'=>'datetime','check_out_at'=>'datetime'];
    public function employee(){ return $this->belongsTo(Employee::class); }
}
