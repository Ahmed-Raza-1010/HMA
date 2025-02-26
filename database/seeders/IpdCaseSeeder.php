<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class IpdCaseSeeder extends Seeder
{
  public function run()
  {
    $faker = Faker::create();

    $patients = DB::table('patients')->pluck('id')->toArray();
    $doctors = DB::table('users')->pluck('id')->toArray();

    foreach (range(1, 10) as $index) {

      // Insert into ipd_cases
      $ipdCaseId = DB::table('ipd_cases')->insertGetId([
        'patient_id' => $faker->randomElement($patients),
        'doctor_id' => $faker->randomElement($doctors),
        'visit_no' => $faker->numberBetween(1, 100),
        'appointment_date' => $faker->date,
        'bed' => $faker->unique()->numberBetween(1, 50),
        'presenting_complaint' => $faker->paragraph(),
        'history' => $faker->text,
        'provisional_diagnose' => $faker->text,
        'treatment' => $faker->text,
        'special_instruction' => $faker->text,
        'follow_up_days' => $faker->numberBetween(1, 30),
        'created_at' => now(),
        'updated_at' => now(),
      ]);

      // Insert multiple medicines for each ipd_case
      $numberOfMedicines = $faker->numberBetween(1, 3);

      foreach (range(1, $numberOfMedicines) as $i) {
        DB::table('medicines')->insert([
          'ipd_case_id' => $ipdCaseId,
          'medicine_name' => $faker->word,
          'dose' => $faker->numberBetween(1, 10),
          'frequency' => $faker->word,
          'duration' => $faker->numberBetween(1, 30),
          'created_at' => now(),
          'updated_at' => now(),
        ]);
      }
    }
  }
}
