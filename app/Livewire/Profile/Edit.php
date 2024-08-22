<?php

namespace App\Livewire\Profile;

use App\Models\User;
use App\Models\Media;
use Livewire\Component;
use App\Models\SiteSetting;
use Livewire\Attributes\On;
use App\Services\FileService;
use Livewire\WithFileUploads;
use App\Services\AlertService;
use Illuminate\Validation\Rule;

class Edit extends Component
{
    use WithFileUploads;

    public $media;
    public $name;
    public $email;
    public bool $checked;

    public function isChecked()
    {
        $siteSetting = SiteSetting::first();

        $siteSetting->update([
            'email_verify_status' => $this->checked
        ]);

        AlertService::alert($this, config('messages.email_verify_toggle'), 'success');
    }

    public function saveProfile()
    {
        $this->validate([
            'media' => 'nullable|file|mimes:png,jpg,jpeg,svg,webp|max:5120',
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

        if ($this->media) {
            // delete previous media
            $media = auth()->user()->media;

            if ($media) {
                $media = (new FileService)->deleteFile($media);
                $media->delete();
            }

            // add updated media
            $url = (new FileService)->storeFile($this->media);

            Media::create([
                'mediable_id' => auth()->id(),
                'mediable_type' => User::class,
                'url' => $url,
                'mime' => 'image'
            ]);
        }

        $this->reset();
        $this->dispatch('profile-reload');
        AlertService::alert($this, config('messages.profile.update'), 'success');
    }

    #[On('profile-reload')]
    public function mount()
    {
        $this->name = auth()->user()->name;
        $this->email = auth()->user()->email;
        $this->checked = SiteSetting::first()->email_verify_status;
    }

    public function render()
    {
        return view('livewire.profile.edit')
            ->title('Profile');
    }
}
