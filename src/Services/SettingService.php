<?php

namespace Helte\DevTools\Services;

use Helte\DevTools\Models\Setting;

class SettingService{
    
    public static function getSetting($key)
    {
        $setting = Setting::where('name', $key)->first();

        return $setting ? $setting->val : null;
    }

    public static function setSetting($key, $value)
    {
        return Setting::updateOrCreate(['name' => $key], ['val' => $value]);
    }
}