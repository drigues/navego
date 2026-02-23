<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // --- Permissions ---
        $permissions = [
            // Users
            'users.view', 'users.create', 'users.edit', 'users.delete',
            // Providers
            'providers.view', 'providers.create', 'providers.edit', 'providers.delete',
            'providers.verify',
            // Services
            'services.view', 'services.create', 'services.edit', 'services.delete',
            // Quotes
            'quotes.view', 'quotes.create', 'quotes.edit', 'quotes.delete',
            'quotes.respond',
            // Categories
            'categories.view', 'categories.create', 'categories.edit', 'categories.delete',
            // Guides
            'guides.view', 'guides.create', 'guides.edit', 'guides.delete', 'guides.publish',
            // News
            'news.view', 'news.create', 'news.edit', 'news.delete', 'news.publish',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // --- Roles ---

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions(Permission::all());

        $provider = Role::firstOrCreate(['name' => 'provider']);
        $provider->syncPermissions([
            'services.view', 'services.create', 'services.edit', 'services.delete',
            'quotes.view', 'quotes.respond',
            'providers.view', 'providers.edit',
        ]);

        $user = Role::firstOrCreate(['name' => 'user']);
        $user->syncPermissions([
            'providers.view',
            'services.view',
            'quotes.view', 'quotes.create',
            'guides.view',
            'news.view',
        ]);
    }
}
