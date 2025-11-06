<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $admin = Role::create(['name' => 'admin']);
        $user = Role::create(['name' => 'user']);

        Permission::create(['name' => 'manage students']);
        Permission::create(['name' => 'manage courses']);
        Permission::create(['name' => 'manage grades']);

        $admin->givePermissionTo(['manage students', 'manage courses', 'manage grades']);
        $user->givePermissionTo(['manage grades']);
    }
}
