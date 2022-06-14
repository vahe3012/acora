<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    public function image(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Attachment::class, 'id', 'value');
    }

    public static function getByKey($key)
    {
        $setting = static::where('key', $key)->first();
        return $setting->value ?? [];
    }

    public static function getHomeSliders()
    {
        $slider = static::getByKey('slider');

        if ($slider) {
            $slider = json_decode($slider);

            foreach ($slider->images as $i => $image) {
                $attachment = Attachment::where('id', $image)->first();

                if ($attachment) {

                    $slider->images[$i] = $attachment->urls['original'];
                }
            }
        }

        return $slider;
    }

    public static function getDescription($key)
    {
        $setting = static::getByKey($key);

        if ($setting) {
            $attribute = 'description_' . \App::getLocale();
            return json_decode($setting)->$attribute;
        }

        return null;
    }
}
