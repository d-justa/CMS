<?php

namespace App\Policies;

use App\Models\User;

class SiteSettingPolicy
{
    public function updateSiteSettings(User $user): bool
    {
        return $user->can('manage general site settings') ||
            $user->can('manage contact site settings') ||
            $user->can('manage advanced site settings');
    }

    public function updateGeneralSettings(User $user): bool
    {
        return $user->can('manage general site settings');
    }

    public function updateContactSettings(User $user): bool
    {
        return $user->can('manage contact site settings');
    }

    public function updateAdvancedSettings(User $user): bool
    {
        return $user->can('manage advanced site settings');
    }
}
