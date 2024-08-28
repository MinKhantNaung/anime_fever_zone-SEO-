<?php

namespace App\Livewire\Profile;

use App\Models\User;
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

    protected $siteSetting;
    protected $alertService;
    protected $fileService;
    protected $mediaService;
    protected $siteSettingService;

    public function boot(SiteSetting $siteSetting, AlertService $alertService, FileService $fileService, MediaService $mediaService, SiteSettingService $siteSettingService)
    {
        $this->siteSetting = $siteSetting;
        $this->alertService = $alertService;
        $this->fileService = $fileService;
        $this->mediaService = $mediaService;
        $this->siteSettingService = $siteSettingService;
    }

    public function isChecked()
    {
        $siteSetting = SiteSetting::first();

        $this->siteSettingService->update($siteSetting, $this->checked);

        $this->alertService->alert($this, config('messages.email.verify_toggle'), 'success');
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
        $this->alertService->alert($this, config('messages.profile.update'), 'success');
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
            $media = $this->fileService->deleteFile($media);
            $media->delete();
        }

        // add updated media
        $url = $this->fileService->storeFile($newMedia);

        $this->mediaService->create(User::class, auth()->user(), $url, 'image');
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
