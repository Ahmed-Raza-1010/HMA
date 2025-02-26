<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class OperationalNoteSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $faker = Faker::create();

    $patients = DB::table('patients')->pluck('id')->toArray();
    $assistants = DB::table('users')
      ->where('designation', 'Assistant')
      ->pluck('id')
      ->toArray();
    $doctors = DB::table('users')
      ->whereIn('designation', ['Surgeon', 'Doctor'])
      ->pluck('id')
      ->toArray();
    $ipdCases = DB::table('ipd_cases')->pluck('id')->toArray();

    foreach (range(1, 10) as $index) {
      DB::table('operational_notes')->insert([
        'patient_id' => $faker->randomElement($patients),
        'ipd_case_id' => $faker->randomElement($ipdCases),
        'procedure_name' => $faker->word,
        'surgeon_id' => $faker->randomElement($assistants),
        'assistant_id' => $faker->randomElement($doctors),
        'indication_of_surgery' => $faker->sentence,
        'operative_findings' => $faker->sentence,
        'post_operation_orders' => $faker->sentence,
        'special_instruction' => $faker->sentence,
        'created_at' => now(),
        'updated_at' => now(),
      ]);
    }
  }
}
