<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('attendance', function (Blueprint $t) {
      $t->id();
      $t->string('employee_id', 50);            // FK logis -> employee.employee_id
      $t->string('attendance_id', 100)->unique();
      $t->timestamp('clock_in')->nullable();
      $t->timestamp('clock_out')->nullable();
      $t->timestamps();

      $t->index('employee_id', 'att_emp_idx');
    });
  }
  public function down(): void { Schema::dropIfExists('attendance'); }
};
