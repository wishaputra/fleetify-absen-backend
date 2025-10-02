<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model {
    protected $fillable = ['name','code','max_checkin_time','max_checkout_time'];
    public function employees(){ return $this->hasMany(Employee::class); }
}
