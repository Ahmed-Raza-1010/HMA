<?php

namespace Database\Seeders;

use App\Models\Medication;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MedicationTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $faker = Faker::create();

    // List of sample medicine names
    $medicineNames = [
      'Paracetamol',
      'Ibuprofen',
      'Amoxicillin',
      'Ciprofloxacin',
      'Metformin',
      'Aspirin',
      'Lisinopril',
      'Atorvastatin',
      'Simvastatin',
      'Omeprazole',
      'Azithromycin',
      'Clindamycin',
      'Doxycycline',
      'Levothyroxine',
      'Losartan',
      'Hydrochlorothiazide',
      'Gabapentin',
      'Prednisone',
      'Cetirizine',
      'Alprazolam'
    ];

    foreach (range(1, 20) as $index) {
      Medication::create([
        'name' => $faker->randomElement($medicineNames),
        'frequency' => $faker->randomElement(['once a day', 'twice a day', 'three times a day']),
        'dose' => $faker->randomElement(['5', '6', '7', '8']),
      ]);
    }
  }
}
