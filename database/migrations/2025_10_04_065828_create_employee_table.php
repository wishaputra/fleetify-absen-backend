<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('employee', function (Blueprint $t) {
      $t->id(); // PK internal
      $t->string('employee_id', 50)->unique(); // ID karyawan (varchar 50)
      $t->unsignedBigInteger('departement_id'); // FK -> departement.id
      $t->string('name', 255);
      $t->text('address')->nullable();
      $t->string('email')->nullable()->unique();
      $t->timestamps();

      // Beri nama FK pendek supaya tidak bentrok
      $t->foreign('departement_id', 'fk_emp_dept')
        ->references('id')->on('departement')
        ->restrictOnDelete()->cascadeOnUpdate();
    });
  }
  public function down(): void { Schema::dropIfExists('employee'); }
};
