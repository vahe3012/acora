<?php

namespace App\Services;

use App\Models\Setting;

class AboutUsService
{
    public static function getLinks(): array
    {
        return [
            'activity',
            'objectives',
            'management',
            'history',
            'founding_documents',
            'partners',
            'members',
            'branches',
            'staff'
        ];
    }

    public static function getContent()
    {
        $aboutContent = Setting::getByKey('about_content');

        if ($aboutContent) {
            $aboutContent = json_decode($aboutContent, true);
        }

        return $aboutContent;
    }
}
