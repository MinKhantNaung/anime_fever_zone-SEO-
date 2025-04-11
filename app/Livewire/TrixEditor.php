<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Modelable;

class TrixEditor extends Component
{
    #[Modelable]
    public $content;

    public function mount($content = '')
    {
        $this->content = $content;
    }

    public function render()
    {
        return view('livewire.trix-editor');
    }
}
