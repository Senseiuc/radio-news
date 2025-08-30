<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create all necessary permissions
        $permissions = [
            // Article permissions
            'viewAny articles',
            'view articles',
            'create articles',
            'update articles',
            'delete articles',
            'publish articles',

            // User permissions
            'viewAny users',
            'view users',
            'create users',
            'update users',
            'delete users',

            // Role permissions
            'viewAny roles',
            'view roles',
            'create roles',
            'update roles',
            'delete roles',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $admin = Role::firstOrCreate(['name' => 'admin'])
            ->givePermissionTo(Permission::all());

        // Editor: can create & update articles, but cannot publish
        $editor = Role::firstOrCreate(['name' => 'editor'])
            ->givePermissionTo([
                'viewAny articles',
                'view articles',
                'create articles',
                'update articles',
            ]);

        // Publisher: can create, update and publish
        $publisher = Role::firstOrCreate(['name' => 'publisher'])
            ->givePermissionTo([
                'viewAny articles',
                'view articles',
                'create articles',
                'update articles',
                'publish articles',
            ]);

        // Regular user role: read-only
        $user = Role::firstOrCreate(['name' => 'user'])
            ->givePermissionTo([
                'viewAny articles',
                'view articles',
            ]);
    }
}
