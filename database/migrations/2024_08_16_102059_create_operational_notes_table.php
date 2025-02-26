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
    Schema::create('operational_notes', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('patient_id');
      $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
      $table->unsignedBigInteger('ipd_case_id');
      $table->foreign('ipd_case_id')->references('id')->on('ipd_cases')->onDelete('cascade');
      $table->string('procedure_name');
      $table->foreignId('surgeon_id')->constrained('users')->onDelete('cascade');
      $table->foreignId('assistant_id')->constrained('users')->onDelete('cascade');
      $table->text('indication_of_surgery')->nullable();
      $table->text('operative_findings')->nullable();
      $table->text('post_operation_orders')->nullable();
      $table->text('special_instruction')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('operational_notes');
  }
};
