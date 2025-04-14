<?php

namespace App\Services;

use App\Models\SiteSetting;

final class SiteSettingService
{
    public function update(SiteSetting $siteSetting, bool $checked): void
    {
        $siteSetting->update([
            'email_verify_status' => $checked
        ]);
    }
}
