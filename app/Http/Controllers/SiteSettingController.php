<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function edit()
    {
        return view('site-settings');
    }

    public function update(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            $setting = SiteSetting::where('key', $key)->first();

            if ($setting) {
                $setting->update([
                    'value' => $value
                ]);
            }
        }

        return back()->with('success', 'Site Settings Updated');
    }
}
