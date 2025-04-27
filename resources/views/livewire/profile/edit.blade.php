<div class="container mx-auto flex flex-wrap py-6">

    <section class="w-full md:w-2/3 flex flex-col items-center px-3">

        <div class="grid grid-cols-12 my-3 w-full">

            <h1 class="font-bold text-2xl my-3 col-span-12">Profile</h1>

            <div class="col-span-12">
                {{-- Trigger Button --}}
                <label for="custom-file-input" class="m-auto max-w-fit flex-col flex gap-3 cursor-pointer">
                    <input wire:model.live='media' type="file" accept=".jpg,.jpeg,.png,.svg,.webp"
                        id="custom-file-input" class="sr-only">

                    <span class="m-auto">
                        @if (auth()->user()->media && !$media)
                            <div class="rounded-full overflow-hidden w-[200px] h-[200px]">
                                <img src="{{ auth()->user()->media->url }}" alt="profile-image"
                                    class="w-full h-full object-cover">
                            </div>
                        @elseif ((auth()->user()->media && $media) || (!auth()->user()->media && $media))
                            <div class="rounded-full overflow-hidden w-[200px] h-[200px]">
                                <img src="{{ $media->temporaryUrl() }}" alt="tag image"
                                    class="w-full h-full object-cover">
                            </div>
                        @else
                            <x-icons.profile-icon class="w-[200px] h-[200px]" />
                        @endif
                    </span>

                    <p class="text-gray-600">Tag image to upload profile image.</p>
                </label>
                @error('media')
                    <x-input-error messages="{{ $message }}" />
                @enderror
            </div>

            <div class="col-span-12">
                <label class="text-xl">Name</label>
                <input wire:model.live="name" type="text" placeholder="Type name"
                    class="input input-primary w-full" />
                @error('name')
                    <x-input-error messages="{{ $message }}" />
                @enderror
            </div>

            <div class="col-span-12 mt-3">
                <label class="text-xl">Email</label>
                <input wire:model.live="email" type="email" placeholder="Type email"
                    class="input input-primary w-full" />
                @error('email')
                    <x-input-error messages="{{ $message }}" />
                @enderror
            </div>

            <div class="col-span-12 text-center">
                <button wire:click.prevent="saveProfile" type="button" class="btn btn-secondary px-5 mt-5">Save</button>
            </div>

            {{-- Lock Email Verification --}}
            @if (auth()->user()->role == 'blogger')
                <div class="col-span-12 md:col-span-6 mt-20">
                    <div class="form-control">
                        <label class="cursor-pointer label">
                            <span class="label-text">Show Email Verification Feature</span>
                            <input type="checkbox" wire:model='checked' wire:change="isChecked"
                                class="checkbox checkbox-secondary" />
                        </label>
                    </div>
                </div>
            @endif

            <livewire:profile.update-password-form />

            <livewire:profile.delete-user-form />
        </div>

    </section>

</div>
