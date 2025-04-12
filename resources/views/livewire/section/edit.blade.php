@section('meta-og')
    <link rel="stylesheet" href="{{ asset('assets/trix/trix.min.css') }}">
    <script src="{{ asset('assets/trix/trix.umd.min.js') }}"></script>
@endsection

<div class="bg-white flex flex-col border gap-y-4 px-5 max-w-5xl mx-auto">

    <header class="w-full py-2 border-b">
        <div class="font-bold text-center border-b-2 border-b-violet-600 py-8 text-3xl text-[#d122e3]">
            Update existing Section
        </div>
    </header>

    <form wire:submit='updateSection'>
        <main class="grid grid-cols-12 gap-3 h-full w-full overflow-hidden">

            {{-- Media --}}
            <aside class="col-span-12 m-auto items-center w-full overflow-scroll">

                @if (count($media) == 0)
                    {{-- Trigger Button --}}
                    <h1 class="text-center">16:9 aspect ratio, recommended like TV screen</h1>
                    <label for="custom-file-input" class="m-auto max-w-fit flex-col flex gap-3 cursor-pointer">
                        <input wire:model.live='media' type="file" multiple accept=".jpg,.jpeg,.png,svg,webp"
                            id="custom-file-input" class="sr-only">

                        <span class="m-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-14 h-14">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                            </svg>
                        </span>

                        <span class="bg-blue-500 text-white text-sm rounded-lg p-2 px-4">
                            If you want to update existing files, Upload
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

                    @error('media.*')
                        <x-input-error messages="{{ $message }}" />
                    @enderror
                @endif

            </aside>

            <aside class="col-span-12 mx-auto items-center w-full">
                <div class="mt-5">
                    <input wire:model="heading" type="text" placeholder="Type heading (optional)"
                        class="input input-bordered input-primary w-full mt-3" />
                    @error('heading')
                        <x-input-error messages="{{ $message }}" />
                    @enderror
                </div>

                <div class="label mt-5">
                    <span class="label-text text-lg text-[#9926f0]">Body (Description)</span>
                </div>
                <div wire:ignore>
                    <input id="trix-editor-content" type="hidden" name="body" value="{{ $body }}">
                    <trix-editor input="trix-editor-content" placeholder="Enter description"></trix-editor>
                </div>
                @error('body')
                    <x-input-error messages="{{ $message }}" />
                @enderror
            </aside>

            <div class="col-span-12 text-center my-4">
                <button class="btn bg-[#d122e3] hover:bg-[#9926f0] text-white">
                    <svg class="w-6 h-6 text-gray-100" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 12h14m-7 7V5" />
                    </svg>
                    Update
                </button>
            </div>

        </main>
    </form>

    <script>
        const trixEditor = document.getElementById('trix-editor-content');
        addEventListener('trix-blur', (event) => {
            @this.set('body', trixEditor.getAttribute('value'))
        })
    </script>

</div>
