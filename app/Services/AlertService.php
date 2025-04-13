<?php

namespace App\Services;

final class AlertService
{
    /**
     * $viewModel is the Livewire component instance
     */
    public function alert($viewModel, string $title, string $iconType): void
    {
        $viewModel->dispatch('swal', [
            'title' => $title,   // title
            'icon' => $iconType, // 'success' or 'error'
            'iconColor' => $iconType == 'success' ? 'green' : 'red' // 'green' or 'red'
        ]);
    }

    /**
     * $viewModel is the Livewire component instance
     */
    public function alertForSubscribe($viewModel, string $title, string $iconType): void
    {
        $viewModel->dispatch('subscribed', [
            'title' => $title,
            'icon' => $iconType,
            'iconColor' => $iconType == 'success' ? 'green' : 'red' // 'green' or 'red'
        ]);
    }
}
