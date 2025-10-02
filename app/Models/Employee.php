<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model {
    protected $fillable = ['employee_code','name','email','department_id'];
    public function department(){ return $this->belongsTo(Department::class); }
    public function attendances(){ return $this->hasMany(Attendance::class); }
}
