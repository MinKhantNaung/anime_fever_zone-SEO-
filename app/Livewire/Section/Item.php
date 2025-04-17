<?php

namespace App\Livewire\Section;

use App\Models\Section;
use Livewire\Component;

final class Item extends Component
{
    public Section $section;

    public function mount()
    {
        $this->section->load('media');
    }

    public function render()
    {
        return view('livewire.section.item');
    }
}
