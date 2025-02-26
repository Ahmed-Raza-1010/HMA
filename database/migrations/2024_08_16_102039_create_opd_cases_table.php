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
        Schema::create('opd_cases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->unsignedBigInteger('doctor_id');
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('visit_no')->unsigned();
            $table->date('appointment_date');
            $table->text('presenting_complaint')->nullable();
            $table->text('history')->nullable();
            $table->text('provisional_diagnose')->nullable();
            $table->text('treatment')->nullable();
            $table->text('special_instruction')->nullable();
            $table->integer('follow_up_days')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opd_cases');
    }
};
