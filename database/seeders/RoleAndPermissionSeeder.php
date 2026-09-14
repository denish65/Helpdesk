<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

      $permissions = [
        'tickets.view',
        'tickets.create',
        'tickets.update',
        'tickets.delete',
        'tickets.assign',
        'users.manage',
        'billing.manage',
      ];


      foreach($permissions as $permission){
        Permission::findOrCreate($permission, 'api');
      }

      $adminRole = Role::findOrCreate('admin', 'api');
      $adminRole->syncPermissions(Permission::all());


      $agentRole = Role::findOrCreate('agent', 'api');
      $agentRole->syncPermissions([
        'tickets.view',
        'tickets.create',
        'tickets.update',
        'tickets.assign',
      ]);

      $customerRole = Role::findOrCreate('customer','api');
      $customerRole->syncPermissions([
        'tickets.view',
        'tickets.create',
      ]);

    }
}
