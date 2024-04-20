@props([
    'source' => '',
    'cover' => false,
])

{{-- x-intersect -- for stop playing when video is covered by screen --}}
<div x-data="{ playing: false, muted: false }" @click.outside="$refs.player.pause()" x-intersect:leave="$refs.player.pause()"
    class="relative h-full w-full m-auto">

    <video x-ref="player" @play="playing=true" @pause="playing=false"
        class="h-full max-h-[800px] w-full {{ $cover == true ? 'object-conver' : '' }}" controls>
        <source src="{{ $source }}" type="video/mp4">
        your browser does not support html5 video
    </video>

</div>
