<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'siakad_url',
                'value' => 'http://localhost:8001',
                'group' => 'api',
            ],
            [
                'key' => 'sima_api_key',
                'value' => 'kunci_rahasia_yang_sama_dengan_spmi',
                'group' => 'api',
            ],
            [
                'key' => 'cache_duration',
                'value' => '60',
                'group' => 'api',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'group' => $setting['group'],
                ]
            );
        }
    }
}