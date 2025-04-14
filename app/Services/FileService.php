<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

final class FileService
{
    public function deleteFile(Media $media): Media
    {
        $prevUrl = $media->url;

        $prevPath = parse_url($prevUrl, PHP_URL_PATH); // Extracts the path part of the URL

        // Remove the '/storage' prefix from the path
        $pathWithoutStorage = str_replace('/storage', '', $prevPath);

        Storage::delete('public/' . $pathWithoutStorage);

        return $media;
    }

    public function storeFile(UploadedFile $uploadedFile): string
    {
        $path = Storage::putFile('public/media', $uploadedFile);

        $url = url(Storage::url($path));

        return $url;
    }

    public function getMime(UploadedFile $uploadedFile): string
    {
        if (str()->contains($uploadedFile->getMimeType(), 'video')) {
            return 'video';
        } else {
            return 'image';
        }
    }
}
