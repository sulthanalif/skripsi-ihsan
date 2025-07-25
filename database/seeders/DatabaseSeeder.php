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
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleKepalaDesa = Role::create(['name' => 'kepala-desa']);
        $roleSekretaris = Role::create(['name' => 'sekretaris']);
        $rolePerangkatDesa = Role::create(['name' => 'perangkat-desa']);
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
            'resident-delete',

            'manage-document-types',
            'document-type',
            'document-field',
            'document-create',

            'document-list',
            'document-list-all',

            'document-approval',

            'action-approve',
            'action-sign',

            'report',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $roleSuperAdmin->givePermissionTo($permissions);

        $permissionWarga = [
            'dashboard',
            'document-list',
            'document-approval',
            'document-create',
        ];

        $roleWarga->givePermissionTo($permissionWarga);

        $permissionAdmin = [
            'dashboard',
            'master-data',

            'manage-residents',
            'resident-create',
            'resident-update',
            'resident-delete',

            'manage-document-types',
            'document-type',
            'document-field',
            'document-create',

            'document-list',
            'document-list-all',

            'document-approval',

            'action-approve',
        ];

        $roleAdmin->givePermissionTo($permissionAdmin);


        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@mail.com',
        ]);

        $superAdmin->assignRole($roleSuperAdmin);

        $admin = User::factory()->create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@mail.com',
        ]);

        $admin->assignRole($roleAdmin);

        $this->call([
            WargaSeeder::class,
            DocumentSeeder::class,
        ]);
    }
}
