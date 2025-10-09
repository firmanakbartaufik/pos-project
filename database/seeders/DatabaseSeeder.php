<?php

namespace Database\Seeders;

use App\Models\Roles;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Roles::create(['name' => 'admin']);
        $cashierRole = Roles::create(['name' => 'kasir']);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@pos.test',
            'password' => bcrypt('password'),
            'role_id' => $adminRole->id
        ]);

        User::create([
            'name' => 'Kasir',
            'email' => 'kasir@pos.test',
            'password' => bcrypt('password'),
            'role_id' => $cashierRole->id
        ]);

        $this->call([
            ProductSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
