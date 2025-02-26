<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Faker\Factory as Faker;

class OpdCaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $faker = Faker::create();

    $patients = DB::table('patients')->pluck('id')->toArray();
    $doctors = DB::table('users')->pluck('id')->toArray();

    foreach (range(1, 10) as $index) {

      // Insert into opd_cases
      $opdCaseId = DB::table('opd_cases')->insertGetId([
        'patient_id' => $faker->randomElement($patients),
        'doctor_id' => $faker->randomElement($doctors),
        'visit_no' => $faker->unique()->numberBetween(1, 100),
        'appointment_date' => $faker->date(),
        'presenting_complaint' => $faker->paragraph(),
        'history' => $faker->text,
        'provisional_diagnose' => $faker->text,
        'treatment' => $faker->text,
        'special_instruction' => $faker->text,
        'follow_up_days' => $faker->numberBetween(1, 30),
        'created_at' => now(),
        'updated_at' => now(),
      ]);

      // Insert multiple medicines for each opd_case
      $numberOfMedicines = $faker->numberBetween(1, 3);

      foreach (range(1, $numberOfMedicines) as $i) {
        DB::table('medicines')->insert([
          'opd_case_id' => $opdCaseId,
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
