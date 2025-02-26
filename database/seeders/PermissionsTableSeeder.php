<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run()
  {
    // Create permissions
    $permissions = [
      'manage patients',
      'manage doctors',
      'manage ipd',
      'manage opd',
      'manage notes',
      'manage discharge',
      'delete records',
    ];

    foreach ($permissions as $permission) {
      Permission::create(['name' => $permission]);
    }

    // Optionally assign permissions to roles
    $adminRole = Role::findByName('full admin');
    $doctorRole = Role::findByName('doctor');
    $assistantRole = Role::findByName('assistant');

    // Assign permissions to roles
    $adminRole->givePermissionTo(Permission::all()); // Full Admin gets all permissions
    $doctorRole->givePermissionTo(Permission::all()); // Doctor gets all permissions
    $assistantRole->givePermissionTo([
      'manage patients',
      'manage ipd',
      'manage opd',
      'manage discharge',
    ]);
  }
}
