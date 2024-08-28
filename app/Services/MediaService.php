<?php

namespace App\Services;

use App\Models\Media;

final class MediaService
{
    protected $media;
    protected $fileService;

    public function __construct(Media $media, FileService $fileService)
    {
        $this->media = $media;
        $this->fileService = $fileService;
    }

    public function create($mainModelClass, $mainModel, $mediaUrl, $mime)
    {
        $this->media->create([
            'mediable_id' => $mainModel->id,    // eg: $post->id
            'mediable_type' => $mainModelClass, // eg: Post::class
            'url' => $mediaUrl,                 // eg: file url
            'mime' => $mime                     // eg: 'image'
        ]);
    }

    public function storeMultipleMedias($mainModelClass, $mainModel, Array $medias)
    {
        foreach ($medias as $media) {
            // get mime type
            $mime = $this->fileService->getMime($media);

            $url = $this->fileService->storeFile($media);

            $this->create($mainModelClass, $mainModel, $url, $mime);
        }
    }

    public function destroy(Media $media)
    {
        $media = $this->fileService->deleteFile($media);
        $media->delete();
    }

    public function destroyMultipleMedias($prevMedia)
    {
        foreach ($prevMedia as $media) {
            $this->destroy($media);
        }
    }
}
