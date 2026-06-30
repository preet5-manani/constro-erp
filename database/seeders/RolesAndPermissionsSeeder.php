<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Administration
            'manage users',
            'manage roles',
            'manage permissions',
            'view audit logs',
            'manage settings',
            // Modules
            'manage planning',
            'manage property',
            'manage purchase',
            'approve purchase',
            'manage sales',
            'manage contractors',
            'view reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $superAdmin->syncPermissions(Permission::all());

        // A second, more limited role as a starting point.
        $manager = Role::firstOrCreate(['name' => 'Manager', 'guard_name' => 'web']);
        $manager->syncPermissions([
            'manage planning',
            'manage property',
            'manage purchase',
            'manage sales',
            'manage contractors',
            'view reports',
        ]);
    }
}
