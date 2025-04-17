<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Livewire\Actions\Logout;

final class NavBar extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }

    #[On('profile-reload')]
    public function render()
    {
        return view('livewire.components.nav-bar');
    }
}
