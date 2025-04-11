<?php

use Livewire\Volt\Component;
use App\Models\Tag;
use App\Models\Media;
use App\Services\FileService;
use App\Services\TagService;
use App\Services\MediaService;
use App\Services\AlertService;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;

new class extends Component {
    use WithFileUploads;

    public $media;
    public $name;
    public $body;

    protected $tagService;
    protected $mediaService;
    protected $alertService;
    protected FileService $fileService;

    public function boot(TagService $tagService, MediaService $mediaService, AlertService $alertService, FileService $fileService)
    {
        $this->tagService = $tagService;
        $this->fileService = $fileService;
        $this->mediaService = $mediaService;
        $this->alertService = $alertService;
    }

    public function mount()
    {
        $this->body = '';
    }

    public function createTag()
    {
        // validate
        $validated = $this->validateRequests();

        DB::beginTransaction();

        try {
            $tag = $this->tagService->create($validated);

            // add media
            $url = $this->fileService->storeFile($this->media);
            $this->mediaService->create(Tag::class, $tag, $url, 'image');

            DB::commit();

            $this->alertService->alert($this, config('messages.tag.create'), 'success');

            $this->reset();
            $this->dispatch('tag-reload');

            return $this->redirectRoute('tags.index', navigate: true);
        } catch (\Exception $e) {
            DB::rollback();

            $this->alertService->alert($this, config('messages.common.error'), 'error');
        }
    }

    protected function validateRequests()
    {
        return $this->validate([
            'media' => 'required|file|mimes:webp|max:5120',
            'name' => 'required|string|max:225|unique:tags,name',
            'body' => 'required|string',
        ]);
    }
}; ?>

@section('meta-og')
    <link rel="stylesheet" href="{{ asset('assets/trix/trix.min.css') }}">
    <script src="{{ asset('assets/trix/trix.umd.min.js') }}"></script>
@endsection

<div class="bg-white flex flex-col border gap-y-4 px-5 max-w-5xl mx-auto">

    <header class="w-full py-2 border-b">
        <h1 class="font-bold text-center border-b-2 border-b-violet-600 py-8 text-3xl text-[#d122e3]">
            Create New Tag
        </h1>
    </header>

    <form wire:submit='createTag'>
        <main class="grid grid-cols-12 gap-3 h-full w-full overflow-hidden">

            {{-- Media --}}
            {{-- left side --}}
            <aside class="col-span-12 m-auto items-center w-full overflow-scroll">

                @if (!$media)
                    {{-- Trigger Button --}}
                    <h1 class="text-center">Recommend Potrait Image like Phone screen</h1>
                    <label for="custom-file-input" class="m-auto max-w-fit flex-col flex gap-3 cursor-pointer">
                        <input wire:model.live='media' type="file" accept=".jpg,.jpeg,.png,.svg,.webp"
                            id="custom-file-input" class="sr-only">

                        <span class="m-auto mt-2">
                            <svg class="w-14 h-14 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M5 4a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V4Zm12 12V5H7v11h10Zm-5 1a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H12Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>

                        <span class="text-black text-sm rounded-lg p-2 px-4">
                            Click To Upload Image
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
                        <input wire:model="name" type="text" class="grow focus:border-[#9926f0] rounded-sm"
                            placeholder="Enter tag name" />
                    </label>
                    @error('name')
                        <x-input-error messages="{{ $message }}" />
                    @enderror


                    <div class="label mt-5">
                        <span class="label-text text-lg text-[#9926f0]">Body (Description)</span>
                    </div>
                    <livewire:trix-editor wire:model='body'>
                        @error('body')
                            <x-input-error messages="{{ $message }}" />
                        @enderror
                </div>
            </aside>

            <div class="col-span-12 text-center my-4">
                <button class="btn bg-[#d122e3] hover:bg-[#9926f0] text-white">
                    <svg class="w-6 h-6 text-gray-100" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 12h14m-7 7V5" />
                    </svg>
                    Create
                </button>
            </div>

        </main>
    </form>

</div>
