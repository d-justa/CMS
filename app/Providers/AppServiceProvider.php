<?php

namespace App\Providers;

use App\Models\SiteSetting;
use App\Policies\RolePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Role::class, RolePolicy::class);
        
        $settings = SiteSetting::all();

        foreach ($settings as $setting) {
            // Store in config('settings.key')
            config()->set('settings.' . $setting->key, $setting->value);
        }
    }
}
