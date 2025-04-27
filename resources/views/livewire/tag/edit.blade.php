@section('meta-og')
    <link rel="stylesheet" href="{{ asset('assets/trix/trix.min.css') }}">
@endsection

<div class="bg-white flex flex-col border gap-y-4 px-5 max-w-5xl mx-auto">

    <header class="w-full py-2 border-b">
        <h1 class="font-bold text-center border-b-2 border-b-violet-600 py-8 text-3xl text-[#d122e3]">
            Update Existing Tag
        </h1>
    </header>

    <form wire:submit='updateTag'>
        <main class="grid grid-cols-12 gap-3 h-full w-full overflow-hidden">

            {{-- Media --}}
            <aside class="col-span-12 m-auto items-center w-full overflow-scroll">

                @if (!$media)
                    {{-- Trigger Button --}}
                    <h1 class="text-center">Recommend Potrait Image like Phone screen</h1>
                    <label for="custom-file-input" class="m-auto max-w-fit flex-col flex gap-3 cursor-pointer">
                        <input wire:model.live='media' type="file" accept=".jpg,.jpeg,.png,.svg,.webp"
                            id="custom-file-input" class="sr-only">

                        <span class="m-auto mt-2">
                            <x-icons.potrait-image-icon />
                        </span>

                        <span class="text-black text-sm rounded-lg p-2 px-4">
                            Upload Image if you want to update previous image
                        </span>
                    </label>
                    @error('media')
                        <x-input-error messages="{{ $message }}" />
                    @enderror
                @else
                    {{-- Show if file count is > 0 --}}
                    <div class="flex overflow-x-scroll w-[500px] h-96 snap-x snap-mandatory gap-2 px-2">
                        <div class="w-full h-full shrink-0 snap-always snap-center">
                            <img src="{{ $media->temporaryUrl() }}" alt="tag image"
                                class="w-full h-full object-contain">
                        </div>
                    </div>

                    @error('media')
                        <x-input-error messages="{{ $message }}" />
                    @enderror
                @endif

            </aside>

            <aside class="col-span-12 m-auto items-center w-full">
                <div>
                    <label class="form-control w-full">
                        <div class="label">
                            <span class="label-text text-lg text-[#9926f0]">Tag name</span>
                        </div>
                        <input wire:model="name" type="text" class="grow focus:border-[#9926f0] rounded-xs"
                            placeholder="Enter tag name" />
                    </label>
                    @error('name')
                        <x-input-error messages="{{ $message }}" />
                    @enderror


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
                </div>
            </aside>

            <div class="col-span-12 text-center my-4">
                <button class="btn bg-[#d122e3] hover:bg-[#9926f0] text-white">
                    <x-icons.plus-icon />
                    Update
                </button>
            </div>

        </main>
    </form>

</div>

@push('scripts')
    <script src="{{ asset('assets/trix/trix.umd.min.js') }}"></script>
    <script>
        const trixEditor = document.getElementById('trix-editor-content');
        addEventListener('trix-blur', (event) => {
            @this.set('body', trixEditor.getAttribute('value'))
        })
    </script>
@endpush
