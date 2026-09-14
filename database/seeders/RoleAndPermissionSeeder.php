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


      foreach(['web','api'] as $guard){

        foreach($permissions as $permission){
            Permission::findOrCreate($permission, $guard);
        }

        $adminRole = Role::findOrCreate('admin', $guard);

        $adminRole->syncPermissions(
            Permission::where("guard_name",$guard)->get()
        );


        $agentRole = Role::findOrCreate('agent', $guard);

        $agentRole->syncPermissions([
            Permission::findByName('tickets.view',$guard),
            Permission::findByName('tickets.create',$guard),
            Permission::findByName('tickets.update',$guard),
            Permission::findByName('tickets.assign',$guard),
        ]);

        $customerRole = Role::findOrCreate('customer',$guard);
        $customerRole->syncPermissions([
            Permission::findByName('tickets.view',$guard),
            Permission::findByName('tickets.create',$guard),
        ]);
      }

      app()[PermissionRegistrar::class]->forgetCachedPermissions();

    }
}
