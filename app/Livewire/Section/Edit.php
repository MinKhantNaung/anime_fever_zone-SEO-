<?php

namespace App\Livewire\Section;

use App\Models\Media;
use App\Models\Section;
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
                    $prev_url = $media->url;

                    $path = parse_url($prev_url, PHP_URL_PATH); // Extracts the path part of the URL

                    // Remove the '/storage' prefix from the path
                    $pathWithoutStorage = str_replace('/storage', '', $path);

                    Storage::delete('public/' . $pathWithoutStorage);

                    $media->delete();
                }

                foreach ($this->media as $media) {
                    // get mime type
                    $mime = $this->getMime($media);

                    $file_name = uniqid() . '_' . $media->getClientOriginalName();

                    $path = $media->storeAs('media', $file_name, 'public');

                    $url = url(Storage::url($path));

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
