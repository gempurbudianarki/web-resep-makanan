<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'bypass-all']);

        $superadmin = Role::create(['name' => 'superadmin']);
        $superadmin->givePermissionTo('bypass-all');

        $user = Role::create(['name' => 'user']);
    }
}
