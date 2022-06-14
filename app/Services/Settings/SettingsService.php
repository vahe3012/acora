<?php

namespace App\Services\Settings;

use App\Models\Setting;

class SettingsService
{
    private $settings;

    const DEFAULT_SETTINGS = [
        'slider' => null,
        'logo_image' => null,
        'phone_number' => '+374 (10) 52 66 94',
        'email' => 'DIRECTOR@UCORA.AM',
        'address_am' => "ՀՀ Ք.ԵՐԵՒԱՆ, ՎԱԶԳԵՆ ՍԱՐԳՍՅԱՆ ՓՈՂ. 26/3, 702 ՍԵՆ",
        'address_en' => "ՀՀ Ք.ԵՐԵՒԱՆ, ՎԱԶԳԵՆ ՍԱՐԳՍՅԱՆ ՓՈՂ. 26/3, 702 ՍԵՆ",
        'map_address' => 'UCORA - Union of Credit Organizations of RA - ՀՀ Վարկային կազմակերպությունների միություն',
        'analyzes_description' => null
    ];

    public function __construct()
    {
        $settings = Setting::whereIn('key', array_keys(self::DEFAULT_SETTINGS))->get();
        $this->settings = [];

        foreach ($settings as $setting) {
            $this->settings[$setting->key] = $setting->value;
        }
    }

    public function get($name)
    {
        if (isset($this->settings[$name])) {
            return $this->settings[$name];
        }

        if (isset(self::DEFAULT_SETTINGS[$name])) {
            return self::DEFAULT_SETTINGS[$name];
        }

        return null;
    }

    public function save($key, $setting = null)
    {
        if (!array_key_exists($key, self::DEFAULT_SETTINGS)) {
            return;
        }

        if (is_array($setting)) { //petqa jshtel
            $value = json_encode($setting);
        } else {
            $value = $setting;
        }


        Setting::updateOrCreate(
            ["key" => $key],
            ["key" => $key, "value" => $value]
        );
    }
}
