<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::updateOrCreate(
            ['id' => 1],
            [
                'facebook_url' => 'https://facebook.com/your-page',
                'zalo_url' => 'https://zalo.me/your-phone',
                'phone' => '0123456789',
            ]
        );
    }
}
