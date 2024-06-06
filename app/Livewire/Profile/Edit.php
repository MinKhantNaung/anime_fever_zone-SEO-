<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;

class Edit extends Component
{
    public $name;
    public $email;

    public function saveProfile()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore(auth()->user()->id)],
        ]);

        auth()->user()->fill([
            'name' => $this->name,
            'email' => $this->email
        ]);

        if (auth()->user()->isDirty('email')) {
            auth()->user()->email_verified_at = null;
        }

        auth()->user()->save();

        $this->reset();
        $this->dispatch('profile-reload');

        $this->dispatch('swal', [
            'title' => 'Profile updated successfully !',
            'icon' => 'success',
            'iconColor' => 'green'
        ]);
    }

    #[On('profile-reload')]
    public function mount()
    {
        $this->name = auth()->user()->name;
        $this->email = auth()->user()->email;
    }

    public function render()
    {
        return view('livewire.profile.edit')
            ->title('Profile');
    }
}
