<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use Faker\Factory as Faker;
use Carbon\Carbon;

class PatientTableSeeder extends Seeder
{
  public function run()
  {
    $faker = Faker::create();
    $currentYear = Carbon::now()->format('Y');
    $currentMonth = Carbon::now()->format('m');
    $lastPatient = Patient::whereYear('created_at', $currentYear)
      ->whereMonth('created_at', $currentMonth)
      ->orderBy('created_at', 'desc')
      ->first();
    $startingMRN = $lastPatient ? $this->incrementMRN($lastPatient->mrn) : "{$currentYear}-{$currentMonth}-000000";

    foreach (range(1, 10) as $index) {
      $mrn = $this->generateNextMRN($startingMRN);
      $startingMRN = $mrn;
      Patient::create([
        'mrn' => $mrn,
        'name' => $faker->name,
        'gender' => $faker->randomElement(['Male', 'Female']),
        // 'date_of_birth' => $faker->date(),
        'age' => $faker->numberBetween(20, 50),
        'city' => $faker->city,
        'phone' => $faker->unique()->numerify('###########'),
        'address' => $faker->address,
        'height' => $faker->randomFloat(2, 150, 200),
        'weight' => $faker->randomFloat(2, 50, 120),
        'pulse' => $faker->numberBetween(60, 100),
        'blood_pressure' => $faker->numberBetween(100, 140) . '/' . $faker->numberBetween(60, 90),
        'temperature' => $faker->randomFloat(1, 36.0, 37.5),
        'respiratory' => $faker->numberBetween(12, 20),
      ]);
    }
  }
  private function incrementMRN($lastMRN)
  {
    $numericPart = intval(substr($lastMRN, -6));
    $newNumericPart = str_pad($numericPart + 1, 6, '0', STR_PAD_LEFT);
    return substr($lastMRN, 0, -6) . $newNumericPart;
  }
  private function generateNextMRN($startingMRN)
  {
    return $this->incrementMRN($startingMRN);
  }
}
