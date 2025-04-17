<?php

namespace App\Livewire\Info;

use Livewire\Component;

final class About extends Component
{
    public function render()
    {
        return view('livewire.info.about')
            ->title('About | Anime Fever Zone');
    }
}
