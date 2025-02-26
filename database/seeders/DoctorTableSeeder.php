<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class DoctorTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $faker = Faker::create();

    foreach (range(1, 10) as $index) {
      User::create([
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'gender' => $faker->randomElement(['Male', 'Female']),
        'designation' => $faker->randomElement(['Doctor', 'Surgeon', 'Assistant']),
        'phone' => $faker->unique()->phoneNumber,
        'city' => $faker->city,
        'address' => $faker->address,
        'password' => bcrypt('12345678'),
        'email_verified_at' => now(),
        'remember_token' => Str::random(10),
      ]);
    }
  }
}
