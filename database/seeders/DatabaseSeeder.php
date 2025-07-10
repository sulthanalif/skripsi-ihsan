<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roleSuperAdmin = Role::create(['name' => 'super-admin']);
        $roleWarga = Role::create(['name' => 'warga']);


        $permissions = [
            'dashboard',
            'master-data',
            'manage-users',
            'user-create',
            'user-update',
            'user-delete',
            'settings',
            'manage-permissions',
            'permission-create',
            'permission-update',
            'permission-delete',
            'manage-roles',
            'role-create',
            'role-update',
            'role-delete',

            'manage-residents',
            'resident-create',
            'resident-update',
            'resident-delete'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $roleSuperAdmin->givePermissionTo($permissions);

        $permissionWarga = [
            'dashboard',
        ];

        $roleWarga->givePermissionTo($permissionWarga);


        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@mail.com',
        ]);

        $superAdmin->assignRole($roleSuperAdmin);

    }
}
