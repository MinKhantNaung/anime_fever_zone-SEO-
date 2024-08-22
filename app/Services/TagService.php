<?php

namespace App\Services;

use App\Models\Tag;

final class TagService
{
    public static function create($validated)
    {
        $tag = Tag::create([
            'name' => $validated['name'],
            'body' => $validated['body']
        ]);

        return $tag;
    }

    public static function update(Tag $tag, $validated)
    {
        $tag->update([
            'name' => $validated['name'],
            'body' => $validated['body']
        ]);
    }

    public static function destroy(Tag $tag)
    {
        $tag->posts()->detach();
        $tag->delete();
    }
}
