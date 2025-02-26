<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('medications', function (Blueprint $table) {
            $table->id(); // Primary key: id
            $table->string('name'); // Medication name
            $table->string('frequency'); // Frequency of medication (e.g., daily, twice a day)
            $table->string('dose'); // Dose of medication (e.g., 500mg, 10ml)
            $table->timestamps(); // Adds created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medications');
    }
};
