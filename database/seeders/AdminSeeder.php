<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Buat role admin jika belum ada
        $role = Role::firstOrCreate(['name' => 'admin']);

        // Buat user admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123')
            ]
        );

        // Assign role
        $admin->assignRole($role);

        echo "Admin created: admin@gmail.com / password123\n";
    }
}
