<?php

namespace App\Livewire\Components;

use Livewire\Attributes\On;
use Livewire\Component;

class NavBar extends Component
{
    #[On('profile-reload')]
    public function render()
    {
        return view('livewire.components.nav-bar');
    }
}
