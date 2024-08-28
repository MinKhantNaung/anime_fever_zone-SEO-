<?php

namespace App\Services;

final class AlertService
{
    public function alert($viewModel, $title, $iconType)
    {
        $viewModel->dispatch('swal', [
            'title' => $title,   // title
            'icon' => $iconType, // 'success' or 'error'
            'iconColor' => $iconType == 'success' ? 'green' : 'red' // 'green' or 'red'
        ]);
    }

    public function alertForSubscribe($viewModel, $title, $iconType)
    {
        $viewModel->dispatch('subscribed', [
            'title' => $title,
            'icon' => $iconType,
            'iconColor' => $iconType == 'success' ? 'green' : 'red' // 'green' or 'red'
        ]);
    }
}
