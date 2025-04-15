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
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Services\SiteSettingService;

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

    public function boot(
        SiteSetting $siteSetting,
        AlertService $alertService,
        FileService $fileService,
        MediaService $mediaService,
        SiteSettingService $siteSettingService
    ) {
        $this->siteSetting = $siteSetting;
        $this->alertService = $alertService;
        $this->fileService = $fileService;
        $this->mediaService = $mediaService;
        $this->siteSettingService = $siteSettingService;
    }

    #[On('profile-reload')]
    public function mount()
    {
        $this->name = auth()->user()->name;
        $this->email = auth()->user()->email;
        $this->checked = SiteSetting::first()->email_verify_status;
    }

    public function isChecked()
    {
        $siteSetting = $this->siteSetting->first();

        $this->siteSettingService->update($siteSetting, $this->checked);

        $this->alertService->alert($this, config('messages.email.verify_toggle'), 'success');
    }

    public function saveProfile()
    {
        $validated = $this->validateRequests();

        DB::transaction(function () use ($validated) {
            $this->updateProfile($validated);
            $this->updateMedia($this->media);
        });

        $this->reset();
        $this->dispatch('profile-reload');
        $this->alertService->alert($this, config('messages.profile.update'), 'success');
    }

    protected function validateRequests()
    {
        return $this->validate([
            'media' => ['nullable', 'file', 'mimes:png,jpg,jpeg,webp', 'max:5120'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore(auth()->user()->id)],
        ]);
    }

    protected function updateProfile($validated)
    {
        auth()->user()->fill([
            'name' => $validated['name'],
            'email' => $validated['email']
        ]);

        if (auth()->user()->isDirty('email')) {
            auth()->user()->email_verified_at = null;
        }

        auth()->user()->save();
    }

    protected function updateMedia($newMedia)
    {
        if ($newMedia) {
            // delete previous media
            $media = auth()->user()->media;

            if ($media) {
                $this->mediaService->destroy($media);
            }

            // add updated media
            $url = $this->fileService->storeFile($newMedia);

            $this->mediaService->create(User::class, auth()->user(), $url, 'image');
        }
    }

    public function render()
    {
        return view('livewire.profile.edit')
            ->title('Profile');
    }
}
