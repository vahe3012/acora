<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Models\Setting;
use App\Services\Settings\SettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function redirect;
use function report;
use function response;
use function view;

class SettingController extends Controller
{
    private $settingsService;


    public function __construct(SettingsService $settings)
    {
        $this->settingsService = $settings;
    }

    public function index()
    {
        $settings = $this->settingsService;
        $slider = json_decode($this->settingsService->get('slider'));
        return view('admin.settings.index', ['slider' => $slider, 'settings' => $settings]);
    }

    public function store(Request $request)
    {
        if ($request->get('lat') && !$request->get('long')) {
            return redirect()->back()->withErrors(['long' => 'The "Longitude" field is required.' ]);
        } elseif ($request->get('long') && !$request->get('lat')) {
            return redirect()->back()->withErrors(['lat' => 'The "Latitude" field is required.' ]);
        }

        $settings = $request->all();

        foreach ($settings as $key => $setting) {
            $this->settingsService->save($key, $setting);
        }

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.settings.index');
    }

    public function show($setting)
    {
        $result = Setting::getByKey($setting);

        if ($result) {
            $result = json_decode($result);
        }

        return response()->json(['result' => $result]);
    }
}
