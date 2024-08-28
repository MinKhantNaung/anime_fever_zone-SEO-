<?php

namespace App\Services;

use App\Models\Tag;

final class TagService
{
    protected $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function create($validated)
    {
        $tag = $this->tag->create([
            'name' => $validated['name'],
            'body' => $validated['body']
        ]);

        return $tag;
    }

    public function update(Tag $tag, $validated)
    {
        $tag->update([
            'name' => $validated['name'],
            'body' => $validated['body']
        ]);
    }

    public function destroy(Tag $tag)
    {
        $tag->posts()->detach();
        $tag->delete();
    }
}
