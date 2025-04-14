<?php

namespace App\Services;

use App\Models\Tag;

final class TagService
{
    public function __construct(private Tag $tag) {}

    public function create(array $attributes): Tag
    {
        return $this->tag->create([
            'name' => $attributes['name'],
            'body' => $attributes['body']
        ]);
    }

    public function update(Tag $tag, array $attributes): void
    {
        $tag->update([
            'name' => $attributes['name'],
            'body' => $attributes['body']
        ]);
    }

    public function destroy(Tag $tag): void
    {
        $tag->posts()->detach();
        $tag->delete();
    }
}
