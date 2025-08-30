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
        //    and base taxonomy (categories)
        $this->call([
            RolePermissionSeeder::class,
            CategorySeeder::class,
        ]);

        // 2. Create the first user (admin)
        $user = User::firstOrCreate(
            ['email' => 'nwadialugideon@gmail.com'],
            [
                'name' => 'senseiuc',
                'password' => Hash::make('senseiuc'),
                'email_verified_at' => now(),
            ]
        );

        // 3. Assign roles
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole && !$user->hasRole('admin')) {
            $user->assignRole($adminRole);
            $this->command->info('Admin user assigned admin role. ✅');
        }

        // 4. Ensure default Site Settings row
        \App\Models\SiteSetting::firstOrCreate([], [
            'radio_stream_url' => 'https://stream.example.com/dummy.mp3',
            'radio_now_playing' => 'Homeland Radio – Live',
            'radio_schedule' => [
                ['day' => 'monday','start' => '08:00','end' => '10:00','title' => 'Morning Drive','host' => 'Ada'],
                ['day' => 'monday','start' => '10:00','end' => '12:00','title' => 'Midday Mix','host' => 'Chike'],
                ['day' => 'tuesday','start' => '08:00','end' => '10:00','title' => 'Morning Drive','host' => 'Ada'],
            ],
        ]);

        // 5. Seed demo articles with local images
        $this->call(ArticleSeeder::class);

        // 6. Seed test ads (custom HTML blocks) for all standard placements
        $this->call(AdSeeder::class);
    }
}
