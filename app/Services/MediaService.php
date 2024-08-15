<?php

namespace App\Services;

use App\Models\Media;

class MediaService
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
}
