<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

final class FileService
{
    public function deleteFile($fileModel)
    {
        $prev_url = $fileModel->url;

        $prev_path = parse_url($prev_url, PHP_URL_PATH); // Extracts the path part of the URL

        // Remove the '/storage' prefix from the path
        $pathWithoutStorage = str_replace('/storage', '', $prev_path);

        Storage::delete('public/' . $pathWithoutStorage);

        return $fileModel;
    }

    public function storeFile($fileModel)
    {
        $file_name = uniqid() . '_' . $fileModel->hashName();

        $path = $fileModel->storeAs('media', $file_name, 'public');

        $url = url(Storage::url($path));

        return $url;
    }

    public function getMime($media): string
    {
        if (str()->contains($media->getMimeType(), 'video')) {
            return 'video';
        } else {
            return 'image';
        }
    }
}
