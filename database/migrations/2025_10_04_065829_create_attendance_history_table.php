<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('attendance_history', function (Blueprint $t) {
      $t->id();
      $t->string('employee_id', 50);
      $t->string('attendance_id', 100);
      $t->timestamp('date_attendance');
      $t->tinyInteger('attendance_type'); // 1=in, 2=out
      $t->text('description')->nullable();
      $t->timestamps();

      // index composite dengan nama pendek (hindari error 1059)
      $t->index(['employee_id','attendance_id','attendance_type'], 'att_hist_idx');
    });
  }
  public function down(): void { Schema::dropIfExists('attendance_history'); }
};
