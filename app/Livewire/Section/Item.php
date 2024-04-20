<?php

namespace App\Livewire\Section;

use App\Models\Section;
use Livewire\Component;

class Item extends Component
{
    public Section $section;

    public function render()
    {
        return view('livewire.section.item');
    }
}
