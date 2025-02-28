
<div class="w-full" id="{{ str_replace(' ', '-', $section->heading) }}">

    <h2 class="font-bold text-2xl sm:text-3xl my-3">{{ $section->heading }}</h2>

    <div class="my-2 max-w-lg mx-auto">
        {{-- Swiper JS --}}
        <div x-data="{
                slides: null
            }" x-init="
            slides = $el.querySelectorAll('.swiper-slide');
            new Swiper($el, {
                modules: [Navigation, Pagination],
                loop: slides.length === 0 || slides.length === 1 ? false : true,

                pagination: {
                    el: '.swiper-pagination',
                },

                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            })" class="swiper border bg-white">
            <!-- Additional required wrapper -->
            <ul x-cloak class="swiper-wrapper">
                <!-- Slides -->
                @foreach ($section->media as $file)
                    <li class="swiper-slide">
                        @switch($file->mime)
                            @case('video')
                                <x-video source="{{ $file->url }}" />
                            @break

                            @case('image')
                                <img src="{{ $file->url }}" alt="image"
                                    class="w-full block object-scale-down">
                            @break

                            @default
                        @endswitch
                    </li>
                @endforeach
            </ul>
            <!-- If we need pagination -->
            <div class="swiper-pagination"></div>

            <!-- If we need navigation buttons -->
            @if ($section->media->count() > 1)
                {{-- prev button --}}
                <div class="swiper-button-prev absolute top-1/2 z-10 p-2">
                    <div class="bg-white/95 border p-1 rounded-full text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2.8" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 19.5 8.25 12l7.5-7.5" />
                        </svg>
                    </div>
                </div>
                {{-- next button --}}
                <div class="swiper-button-next absolute right-0 top-1/2 z-10 p-2">
                    <div class="bg-white/95 border p-1 rounded-full text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2.8" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </div>
                </div>
            @endif

            <!-- If we need scrollbar -->
            <div class="swiper-scrollbar"></div>

        </div>
    </div>

    <p class="text-lg font-medium text-gray-700 leading-9">{!! $section->body !!}</p>

</div>
