<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Services\Settings\SettingsService;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeder = SettingsService::DEFAULT_SETTINGS;

        foreach ($seeder as $key => $setting) {
            $settingExists = Setting::where('key', $key)->first();

            if (!$settingExists) {
                Setting::create([
                    'key' => $key,
                    'value' => $setting
                ]);
            }
        }
    }
}
