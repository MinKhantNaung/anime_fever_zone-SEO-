<?php

namespace App\Livewire\Section;

use App\Models\Media;
use App\Models\Section;
use App\Services\FileService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class Edit extends ModalComponent
{
    use WithFileUploads;

    public $media = [];
    public $heading;
    public $body;

    public Section $section;

    public static function modalMaxWidth(): string
    {
        return '5xl';
    }

    public function updateSection()
    {
        $this->validate([
            'media.*' => 'file|mimes:png,jpg,jpeg,svg,webp,mp4|max:512000',
            'heading' => 'nullable|string|max:255',
            'body' => 'required|string'
        ]);

        DB::beginTransaction();

        try {
            $this->section->update([
                'heading' => $this->heading,
                'body' => $this->body
            ]);

            if (count($this->media) > 0) {
                $prev_media = $this->section->media;

                // delete previous media
                foreach ($prev_media as $media) {
                    $media = FileService::deleteFile($media);

                    $media->delete();
                }

                foreach ($this->media as $media) {
                    // get mime type
                    $mime = $this->getMime($media);

                    $url = FileService::storeFile($media);

                    // create media
                    Media::create([
                        'mediable_id' => $this->section->id,
                        'mediable_type' => Section::class,
                        'url' => $url,
                        'mime' => $mime
                    ]);
                }
            }

            DB::commit();

            // success toast
            $this->dispatch('swal', [
                'title' => 'Section updated successfully !',
                'icon' => 'success',
                'iconColor' => 'green'
            ]);

            return $this->redirectRoute('sections.index', ['post' => $this->section->post_id], navigate: true);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            $this->dispatch('swal', [
                'title' => 'An unexpected error occurred. Please try again later.',
                'icon' => 'error',
                'iconColor' => 'red'
            ]);
        }
    }

    public function getMime($media): string
    {
        if (str()->contains($media->getMimeType(), 'video')) {
            return 'video';
        } else {
            return 'image';
        }
    }

    public function mount()
    {
        $this->heading = $this->section->heading;
        $this->body = $this->section->body;
    }

    public function render()
    {
        return view('livewire.section.edit');
    }
}
