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
use App\Services\MediaService;
use App\Services\SiteSettingService;
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

        SiteSettingService::update($siteSetting, $this->checked);

        AlertService::alert($this, config('messages.email.verify_toggle'), 'success');
    }

    public function saveProfile()
    {
        $this->validateInputs();

        $this->updateProfile();

        if ($this->media) {
            $this->updateMedia($this->media);
        }

        $this->reset();
        $this->dispatch('profile-reload');
        AlertService::alert($this, config('messages.profile.update'), 'success');
    }

    protected function validateInputs()
    {
        $this->validate([
            'media' => 'nullable|file|mimes:png,jpg,jpeg,svg,webp|max:5120',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore(auth()->user()->id)],
        ]);
    }

    protected function updateProfile()
    {
        auth()->user()->fill([
            'name' => $this->name,
            'email' => $this->email
        ]);

        if (auth()->user()->isDirty('email')) {
            auth()->user()->email_verified_at = null;
        }

        auth()->user()->save();
    }

    protected function updateMedia($newMedia)
    {
        // delete previous media
        $media = auth()->user()->media;

        if ($media) {
            $media = FileService::deleteFile($media);
            $media->delete();
        }

        // add updated media
        $url = FileService::storeFile($newMedia);

        MediaService::create(User::class, auth()->user(), $url, 'image');
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
