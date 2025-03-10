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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('mrn');
            $table->string('name');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            // $table->date('date_of_birth');
            $table->integer('age');
            $table->string('city');
            $table->string('phone')->unique();
            $table->text('address');
            $table->float('height')->nullable();
            $table->float('weight')->nullable();
            $table->integer('pulse')->nullable();
            $table->string('blood_pressure')->nullable();
            $table->float('temperature')->nullable();
            $table->integer('respiratory')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
