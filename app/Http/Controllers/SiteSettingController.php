<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactDetailRequest;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SiteSettingController extends Controller
{
    public function edit()
    {
        Gate::authorize('updateSiteSettings', SiteSetting::class);

        $abilities = collect([
            'general' => 'updateGeneralSettings',
            'contact' => 'updateContactSettings',
            'advance' => 'updateAdvancedSettings',
        ]);

        $defaultTab = $abilities->keys()->first(function ($key) use ($abilities) {
            return Gate::allows($abilities[$key], SiteSetting::class);
        });

        return view('site-settings', compact('defaultTab'));
    }

    public function updateGeneralSettings(Request $request)
    {
        Gate::authorize('updateGeneralSettings', SiteSetting::class);
        $validatedData = $request->validate([
            'site_title' => 'required',
            'site_tag_line' => 'nullable',
        ]);

        foreach ($validatedData as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'Settings updated!');
    }

    public function updateContactSettings(StoreContactDetailRequest $request)
    {
        Gate::authorize('updateContactSettings', SiteSetting::class);

        $validatedData = $request->validated();

        foreach ($validatedData as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Contact details saved successfully.');
    }

    public function updateAdvancedSettings(Request $request)
    {
        Gate::authorize('updateAdvancedSettings', SiteSetting::class);
        $disable_interactions = $request->has('disable_interactions') ? 1 : 0;
        $disable_form_autocomplete = $request->has('disable_form_autocomplete') ? 1 : 0;

        SiteSetting::updateOrCreate(
            ['key' => 'disable_interactions'],
            ['value' => $disable_interactions]
        );
        SiteSetting::updateOrCreate(
            ['key' => 'disable_form_autocomplete'],
            ['value' => $disable_form_autocomplete]
        );

        return back()->with('success', 'Settings updated!');
    }
}
