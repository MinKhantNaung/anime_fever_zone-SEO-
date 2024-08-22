<?php

namespace App\Services;

final class SiteSettingService
{
    public static function update($model, bool $checked)
    {
        $model->update([
            'email_verify_status' => $checked
        ]);
    }
}
