<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AboutRequest;
use App\Models\Setting;
use App\Services\AboutUsService;
use Illuminate\Support\Facades\DB;

class AboutController extends Controller
{
    public function index()
    {
        $aboutContent = AboutUsService::getContent();
        return view('admin.about.index', compact('aboutContent'));
    }

    public function store(AboutRequest $request)
    {
        $validated = $request->validated();
        $key = 'about_content';
        $value = json_encode($validated);

        try {
            DB::beginTransaction();
            $setting = Setting::where('key', $key)->first();

            if ($setting) {
                $setting->value = $value;
                $setting->save();
            } else {
                Setting::create([
                    'key' => $key,
                    'value' => $value
                ]);
            }

            DB::commit();
            return redirect()->route('admin.about.index')->withSuccess('Successfully Created!');
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
            return redirect()->back()->withInput()->withError($exception->getMessage());
        }
    }
}
