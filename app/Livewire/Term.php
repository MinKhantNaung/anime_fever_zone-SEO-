<?php

namespace App\Livewire;

use Livewire\Component;

final class Term extends Component
{
    public function render()
    {
        return view('livewire.term')
            ->title('Terms & Conditions | Anime Fever Zone');
    }
}
