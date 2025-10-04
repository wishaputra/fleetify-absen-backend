<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    protected $table = 'departement';
    protected $fillable = ['departement_name','max_clock_in_time','max_clock_out_time'];
}

