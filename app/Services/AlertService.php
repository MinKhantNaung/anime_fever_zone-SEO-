<?php

namespace App\Services;

class AlertService
{
    public static function alert($viewModel, $title, $iconType, $color)
    {
        $viewModel->dispatch('swal', [
            'title' => $title,   // title
            'icon' => $iconType, // 'success' or 'error'
            'iconColor' => $color // 'green' or 'red'
        ]);
    }
}
