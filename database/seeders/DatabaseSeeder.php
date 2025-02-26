<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    \App\Models\User::factory()->create([
      'name' => 'Usman',
      'email' => 'usman@tmh.com',
      'gender' => 'Male',
      'designation' => 'Doctor',
      'phone' => '0300-1234563',
      'city' => 'Gujrat',
      'address' => 'GT Road Gujrat',
      'password' => bcrypt('usman001'),
    ]);

    \App\Models\User::factory()->create([
      'name' => 'Tamoor',
      'email' => 'tamoor@tmh.com',
      'gender' => 'Male',
      'designation' => 'Doctor',
      'phone' => '0300-1234564',
      'city' => 'Gujrat',
      'address' => 'GT Road Gujrat',
      'password' => bcrypt('tamoor007'),
    ]);

    \App\Models\User::factory()->create([
      'name' => 'Ali',
      'email' => 'ali@tmh.com',
      'gender' => 'Male',
      'designation' => 'Assistant',
      'phone' => '0300-1234565',
      'city' => 'Gujrat',
      'address' => 'GT Road Gujrat',
      'password' => bcrypt('ali009'),
    ]);

    // \App\Models\User::factory(7)->create();

    $this->call([
      RolesTableSeeder::class,
      PermissionsTableSeeder::class,
      // PatientTableSeeder::class,
      // DoctorTableSeeder::class,
      // IpdCaseSeeder::class,
      // OpdCaseSeeder::class,
      // OperationalNoteSeeder::class,
      // DischargePlanSeeder::class,
      // MedicationTableSeeder::class,
      RoleAssignmentSeeder::class,
    ]);
  }
}
