<?php

namespace App\Livewire;

use Livewire\Component;

class Privacy extends Component
{
    public function render()
    {
        return view('livewire.privacy')
            ->title('Privacy Policy | Anime Fever Zone');
    }
}
