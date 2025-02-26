<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('medicines', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('ipd_case_id')->nullable();
      $table->unsignedBigInteger('opd_case_id')->nullable();
      $table->string('medicine_name');
      $table->integer('dose');
      $table->string('frequency');
      $table->integer('duration');
      $table->timestamps();
      $table->foreign('ipd_case_id')->references('id')->on('ipd_cases')->onDelete('cascade');
      $table->foreign('opd_case_id')->references('id')->on('opd_cases')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('medicines');
  }
};
