<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = Role::firstOrCreate(['name' => 'super admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('admin123'),
        ]);

        $superAdmin->assignRole($superAdminRole);

        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@mail.com',
            'password' => bcrypt('user123'),
        ]);

        $user->assignRole($userRole);
    }
}
