<?php

namespace Database\Seeders;

use App\Enums\Roles;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@surfind.es',
            'password' => bcrypt('admin1234'),
        ]);

        $admin->assignRole(Roles::ADMIN->value);
    }
}
