<nav class="w-full py-4 shadow-sm bg-linear-to-r from-[#9926f0] to-[#d122e3]">
    <div class="w-full container mx-auto flex flex-nowrap items-center justify-between">

        <nav>
            <ul
                class="flex items-center justify-between font-bold text-sm text-white pl-2 sm:pl-6 uppercase no-underline">
                <li>
                    <a wire:navigate href="{{ route('home') }}" class="hover:text-gray-200 hover:underline px-4">
                        <img src="{{ asset('favicon.ico') }}" alt="anime fever zone logo" class="w-9">
                    </a>
                </li>
                <li><a wire:navigate href="{{ route('home') }}"
                        class="hover:text-gray-200 hover:underline px-4">Home</a></li>
            </ul>
        </nav>

        <div class="flex items-center text-lg no-underline text-white pr-0 sm:pr-6 pl-5 sm:pl-0">

            @guest
                <a wire:navigate href="{{ route('login') }}" class="px-2 hover:text-gray-200 hover:underline">
                    Log in
                </a>
                <a wire:navigate href="{{ route('register') }}" class="px-2 hover:text-gray-200 hover:underline">
                    Register
                </a>
            @endguest

            <!-- Profile -->
            @auth
                <button wire:click.prevent="logout" class="px-2 hover:text-gray-200 hover:underline">
                    Log out
                </button>
                {{-- Profile --}}
                <a wire:navigate href="{{ route('profile.edit') }}" class="px-2 hover:text-gray-200 hover:underline">
                    @if (auth()->user()->media)
                        <img src="{{ auth()->user()->media->url }}" alt="profile-image"
                            class="w-[36px] h-[36px] rounded-full object-cover">
                    @else
                        <x-icons.profile-icon />
                    @endif
                </a>
            @endauth
        </div>
    </div>

</nav>
