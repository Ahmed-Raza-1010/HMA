<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class DischargePlanSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $faker = Faker::create();

    $patients = DB::table('patients')->pluck('id')->toArray();
    $ipdCases = DB::table('ipd_cases')->pluck('id')->toArray();

    foreach (range(1, 10) as $index) {
      DB::table('discharge_plans')->insert([
        'patient_id' => $faker->randomElement($patients),
        'ipd_case_id' => $faker->randomElement($ipdCases),
        'operative_findings' => $faker->sentence,
        'treatment_in_hospital' => $faker->paragraph,
        'treatment_in_home' => $faker->paragraph,
        'created_at' => now(),
        'updated_at' => now(),
      ]);
    }
  }
}
