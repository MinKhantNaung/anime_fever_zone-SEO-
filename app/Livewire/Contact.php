<?php

namespace App\Livewire;

use Livewire\Component;

class Contact extends Component
{
    public function render()
    {
        return view('livewire.contact')
            ->title('Contact | Anime Fever Zone');
    }
}
