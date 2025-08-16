<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. First, run the seeder that creates roles and permissions
        //    This is crucial because the 'admin' role needs to exist
        //    before you can assign it to a user.
        $this->call([
            RolePermissionSeeder::class,
            CategorySeeder::class,
        ]);

        // 2. Create the first user
        $user = User::factory()->create([
            'name' => 'senseiuc',
            'email' => 'nwadialugideon@gmail.com',
            'password' => Hash::make('senseiuc'), // Add a default password
            'email_verified_at' => now(),
        ]);

        // 3. Assign the 'admin' role to the created user
        $adminRole = Role::where('name', 'admin')->first();

        if ($adminRole) {
            $user->assignRole($adminRole);
            $this->command->info('Admin user "senseiuc" created and assigned admin role. ✅');
        } else {
            $this->command->error('Admin role not found. Ensure RolePermissionSeeder ran successfully. ❌');
        }
    }
}
