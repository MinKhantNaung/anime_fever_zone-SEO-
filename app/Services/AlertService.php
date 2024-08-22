<?php

namespace App\Services;

class AlertService
{
    public static function alert($viewModel, $title, $iconType)
    {
        $viewModel->dispatch('swal', [
            'title' => $title,   // title
            'icon' => $iconType, // 'success' or 'error'
            'iconColor' => $iconType == 'success' ? 'green' : 'red' // 'green' or 'red'
        ]);
    }
}
