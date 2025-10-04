<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employee';

    // PK internal tetap 'id' (autoincrement) — sesuai migration.
    // 'employee_id' adalah kode karyawan (varchar, unique) yang dipakai di attendance.

    protected $fillable = [
        'employee_id',     // varchar(50), unique
        'name',
        'address',
        'email',
        'departement_id',
    ];

    public function departement()
    {
        return $this->belongsTo(Departement::class, 'departement_id');
    }
}
