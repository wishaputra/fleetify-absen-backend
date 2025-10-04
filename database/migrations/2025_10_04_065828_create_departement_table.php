<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('departement', function (Blueprint $t) {
      $t->id();
      $t->string('departement_name', 255)->unique();
      $t->time('max_clock_in_time');
      $t->time('max_clock_out_time');
      $t->timestamps();
    });
  }
  public function down(): void { Schema::dropIfExists('departement'); }
};
