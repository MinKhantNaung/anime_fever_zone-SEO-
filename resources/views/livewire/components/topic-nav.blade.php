<nav class="w-full py-4 border-t border-b bg-gray-100" x-data="{ open: false }">
    <div class="block sm:hidden">
        <a href="#" class="block md:hidden text-base font-bold uppercase text-center justify-center items-center"
            @click="open = !open">
            Topics <i :class="open ? 'fa-chevron-down' : 'fa-chevron-up'" class="fas ml-2"></i>
        </a>
    </div>
    <div :class="open ? 'block' : 'hidden'" class="w-full flex-grow sm:flex sm:items-center sm:w-auto">
        <div
            class="w-full container mx-auto flex flex-col sm:flex-row items-center justify-center text-sm font-bold uppercase mt-0 px-6 py-2">


            @foreach ($topics as $topic)
                <a wire:navigate href="{{ route('topic', $topic->slug) }}"
                    class="hover:bg-gradient-to-r hover:from-[#9926f0] hover:to-[#d122e3] rounded py-2 px-4 mx-2 {{ request()->is('topic/' . $topic->slug) ? 'bg-[#9926f0]' : '' }}">{{ $topic->name }}</a>
            @endforeach

            @auth
                @if (auth()->user()->role === 'blogger')
                    <a wire:navigate href="{{ route('topics.create') }}"
                        class="hover:bg-gradient-to-r hover:from-[#9926f0] hover:to-[#d122e3] rounded py-2 px-4 mx-2 {{ request()->routeIs('topics.create') ? 'bg-[#9926f0]' : '' }}">Topics(Blogger)</a>
                    <a wire:navigate href="{{ route('tags.index') }}"
                        class="hover:bg-gradient-to-r hover:from-[#9926f0] hover:to-[#d122e3] rounded py-2 px-4 mx-2 {{ request()->routeIs('tags.index') ? 'bg-[#9926f0]' : '' }}">Tags(Blogger)</a>
                    <a wire:navigate href="{{ route('posts.index') }}"
                        class="hover:bg-gradient-to-r hover:from-[#9926f0] hover:to-[#d122e3] rounded py-2 px-4 mx-2 {{ request()->routeIs('posts.index') ? 'bg-[#9926f0]' : '' }}">Posts(Blogger)</a>
                @endif
            @endauth

        </div>
    </div>
</nav>
