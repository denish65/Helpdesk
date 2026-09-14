<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([RoleAndPermissionSeeder::class]);

        $admin = User::factory()->create([
            'name'  => 'Admin User',
            'email' => 'admin@helpdesk.test',
        ]);
        $admin->assignRole('admin');

        $agent = User::factory()->create([
            'name'  => 'Agent User',
            'email' => 'agent@helpdesk.test',
        ]);
        $agent->assignRole('agent');

        $customer = User::factory()->create([
            'name'  => 'Customer User',
            'email' => 'customer@helpdesk.test',
        ]);
        $customer->assignRole('customer');

        User::factory(100)->create()->each(function ($user){
          $user->assignRole("customer");
        });


    }
}
