<?php

namespace App\Services;

use App\Models\Media;

final class MediaService
{
    public static function create($mainModelClass, $mainModel, $mediaUrl, $mime)
    {
        Media::create([
            'mediable_id' => $mainModel->id,    // eg: $post->id
            'mediable_type' => $mainModelClass, // eg: Post::class
            'url' => $mediaUrl,                 // eg: file url
            'mime' => $mime                     // eg: 'image'
        ]);
    }

    public static function storeMultipleMedias($mainModelClass, $mainModel, Array $medias)
    {
        foreach ($medias as $media) {
            // get mime type
            $mime = FileService::getMime($media);

            $url = FileService::storeFile($media);

            MediaService::create($mainModelClass, $mainModel, $url, $mime);
        }
    }

    public static function destroy(Media $media)
    {
        $media = FileService::deleteFile($media);
        $media->delete();
    }

    public static function destroyMultipleMedias($prevMedia)
    {
        foreach ($prevMedia as $media) {
            self::destroy($media);
        }
    }
}
