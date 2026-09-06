<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'manage users',
            'manage master',
            'manage school settings',
            'create incoming_letter',
            'read incoming_letter',
            'update incoming_letter',
            'delete incoming_letter',
            'create outgoing_letter',
            'read outgoing_letter',
            'update outgoing_letter',
            'delete outgoing_letter',
            'print outgoing_letter',
            'verify outgoing_letter',
            'send outgoing_letter',
            'archive outgoing_letter',
            'approve outgoing_letter',
            'disposition.create',
            'disposition.respond',
            'export data',
            'view dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        $allPermissions = Permission::where('guard_name', 'web')->get();
        $roles = [
            'Super Admin' => $allPermissions,
            'Admin' => $allPermissions->whereNotIn('name', []),
            'Pimpinan' => $allPermissions->whereIn('name', [
                'read incoming_letter',
                'read outgoing_letter',
                'approve outgoing_letter',
                'verify outgoing_letter',
                'print outgoing_letter',
                'disposition.create',
                'view dashboard',
                'export data',
            ]),
            'Staff' => $allPermissions->whereIn('name', [
                'read incoming_letter',
                'create incoming_letter',
                'update incoming_letter',
                'read outgoing_letter',
                'create outgoing_letter',
                'update outgoing_letter',
                'print outgoing_letter',
                'disposition.respond',
                'view dashboard',
            ]),
        ];

        foreach ($roles as $name => $rolePermissions) {
            Role::findOrCreate($name, 'web')->syncPermissions($rolePermissions);
        }
    }
}
