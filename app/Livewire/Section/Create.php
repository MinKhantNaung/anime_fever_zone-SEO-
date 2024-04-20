<?php

namespace App\Livewire\Section;

use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class Create extends ModalComponent
{
    use WithFileUploads;

    public $media = [];
    public $body;

    public static function modalMaxWidth(): string
    {
        return '5xl';
    }

    public function addSection()
    {
        dd($this->media);
    }

    public function render()
    {
        return view('livewire.section.create');
    }
}
