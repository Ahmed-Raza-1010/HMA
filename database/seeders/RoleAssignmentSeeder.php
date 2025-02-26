<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleAssignmentSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Ensure roles exist
    $adminRole = Role::firstOrCreate(['name' => 'full admin']);
    $doctorRole = Role::firstOrCreate(['name' => 'doctor']);
    $assistantRole = Role::firstOrCreate(['name' => 'assistant']);

    // Assign roles to users
    $users = User::all(); // Get all users, or you can filter specific users

    foreach ($users as $user) {
      if ($user->email === 'usman@tmh.com') {
        $user->assignRole($adminRole);
      } else if ($user->email === 'tamoor@tmh.com') {
        $user->assignRole($doctorRole);
      } else {
        $user->assignRole($assistantRole);
      }
    }
  }
}
