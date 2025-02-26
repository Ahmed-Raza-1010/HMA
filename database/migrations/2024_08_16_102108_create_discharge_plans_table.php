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
    Schema::create('discharge_plans', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('patient_id');
      $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
      $table->unsignedBigInteger('ipd_case_id');
      $table->foreign('ipd_case_id')->references('id')->on('ipd_cases')->onDelete('cascade');
      $table->text('operative_findings')->nullable();
      $table->text('treatment_in_hospital')->nullable();
      $table->text('treatment_in_home')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('discharge_plans');
  }
};
