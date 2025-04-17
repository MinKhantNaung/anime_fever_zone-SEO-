<?php

namespace App\Livewire;

use Livewire\Component;

final class Privacy extends Component
{
    public function render()
    {
        return view('livewire.privacy')
            ->title('Privacy Policy | Anime Fever Zone');
    }
}
