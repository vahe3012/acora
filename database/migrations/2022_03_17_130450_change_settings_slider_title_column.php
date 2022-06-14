<?php

use Illuminate\Database\Migrations\Migration;

class ChangeSettingsSliderTitleColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sliders = json_decode(\App\Models\Setting::getByKey('slider'));
        $changedSliders = [];

        foreach ($sliders as $slider) {
            $changedSliders[] = [
                'slider' => $slider->slider,
                'title_am' => $slider->title,
                'title_en' => $slider->title,
                'additional_link' => $slider->additional_link
            ];
        }

        \App\Models\Setting::where('key', 'slider')->update(['value' => json_encode($changedSliders)]);
    }
}
