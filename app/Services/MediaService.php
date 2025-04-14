<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

final class MediaService
{
    public function __construct(
        private Media $media,
        private FileService $fileService
    ) {}

    public function create(string $relatedModelClass, Model $relatedModel, string $mediaUrl, string $mimeType): void
    {
        $this->media->create([
            'mediable_id' => $relatedModel->id,     // eg: $post->id
            'mediable_type' => $relatedModelClass,  // eg: Post::class
            'url' => $mediaUrl,                     // eg: file url
            'mime' => $mimeType                     // eg: 'image'
        ]);
    }

    public function storeMultipleMedias(string $relatedModelClass, Model $relatedModel, array $uploadedFiles): void
    {
        foreach ($uploadedFiles as $uploadedFile) {
            $mime = $this->fileService->getMime($uploadedFile);
            $url = $this->fileService->storeFile($uploadedFile);

            $this->create($relatedModelClass, $relatedModel, $url, $mime);
        }
    }

    public function destroy(Media $media): void
    {
        $media = $this->fileService->deleteFile($media);
        $media->delete();
    }

    /**
     * @param Media[] $mediaItems
     */
    public function destroyMultipleMedias(Collection|array $mediaItems): void
    {
        foreach ($mediaItems as $media) {
            $this->destroy($media);
        }
    }
}
