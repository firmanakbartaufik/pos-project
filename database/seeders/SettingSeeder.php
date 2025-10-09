<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::create([
            'store_name' => 'Toko POS Laravel',
            'discount' => 0,
        ]);
    }
}
