<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Services\AlertService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class UpdatePasswordForm extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    protected $alertService;

    public function boot(AlertService $alertService)
    {
        $this->alertService = $alertService;
    }

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');

        $this->alertService->alert($this, config('messages.password.update'), 'success');
    }

    public function render()
    {
        return view('livewire.profile.update-password-form');
    }
}
