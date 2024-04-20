<div class="bg-white lg:h-[500px] flex flex-col border gap-y-4 px-5">

    <header class="w-full py-2 border-b">
        <div class="flex justify-between">
            <button wire:click="$dispatch('closeModal')" class="font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.9"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="text-lg font-bold">
                Add New Section
            </div>

            <button wire:loading.attr='disabled' wire:click.prevent='addSection' type="button"
                class="text-blue-500 font-bold">
                Submit
            </button>
        </div>
    </header>

    <main class="grid grid-cols-12 gap-3 h-full w-full overflow-hidden">

        {{-- Media --}}
        {{-- left side --}}
        <aside class="col-span-12 lg:col-span-7 m-auto items-center w-full overflow-scroll">

            @if (count($media) == 0)
                {{-- Trigger Button --}}
                <h1 class="text-center">16:9 aspect ratio, recommended like TV screen)</h1>
                <label for="custom-file-input" class="m-auto max-w-fit flex-col flex gap-3 cursor-pointer">
                    <input wire:model.live='media' type="file" multiple accept=".jpg,.jpeg,.png,svg,webp"
                        id="custom-file-input" class="sr-only">

                    <span class="m-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-14 h-14">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                    </span>

                    <span class="bg-blue-500 text-white text-sm rounded-lg p-2 px-4">
                        Upload files
                    </span>
                </label>
            @else
                {{-- Show if file count is > 0 --}}
                <div class="flex overflow-x-scroll w-[500px] h-96 snap-x snap-mandatory gap-2 px-2">
                    @foreach ($media as $index => $file)
                        <div class="w-full h-full shrink-0 snap-always snap-center">
                            @if (strpos($file->getMimeType(), 'image') !== false)
                                <img src="{{ $file->temporaryUrl() }}" alt=""
                                    class="w-full h-full object-contain">
                            @elseif (strpos($file->getMimeType(), 'video') !== false)
                                <x-video :source="$file->temporaryUrl()" />
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

        </aside>

        <aside class="col-span-12 lg:col-span-5 mx-auto items-center w-full">
            <div>
                <input wire:model="heading" type="text" placeholder="Type heading (optional)"
                    class="input input-bordered input-secondary w-full mt-3" />
                @error('heading')
                    <x-input-error messages="{{ $message }}" />
                @enderror
            </div>

            <div>
                <textarea wire:model="body" class="textarea textarea-secondary w-full mt-3" placeholder="Enter description"></textarea>
                @error('body')
                    <x-input-error messages="{{ $message }}" />
                @enderror
            </div>
        </aside>

    </main>

</div>
