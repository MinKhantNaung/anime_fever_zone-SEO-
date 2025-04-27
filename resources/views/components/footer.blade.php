<footer class="w-full border-t pb-12 shadow-sm bg-linear-to-r from-[#9926f0] to-[#d122e3] text-white">
    <div class="w-full container mx-auto flex flex-col items-center">
        <div class="flex flex-col md:flex-row text-center md:text-left md:justify-between py-6">
            <a wire:navigate href="{{ route('about') }}" class="uppercase px-3 hover:text-gray-200 hover:underline {{ request()->routeIs('about') ? 'underline' : '' }}">About</a>
            <a wire:navigate href="{{ route('privacy') }}" class="uppercase px-3 hover:text-gray-200 hover:underline {{ request()->routeIs('privacy') ? 'underline' : '' }}">Privacy Policy</a>
            <a wire:navigate href="{{ route('term') }}" class="uppercase px-3 hover:text-gray-200 hover:underline {{ request()->routeIs('term') ? 'underline' : '' }}">Terms & Conditions</a>
            <a wire:navigate href="{{ route('contact') }}" class="uppercase px-3 hover:text-gray-200 hover:underline {{ request()->routeIs('contact') ? 'underline' : '' }}">Contact Us</a>
        </div>
        <div class="uppercase pb-6">&copy; animefeverzone.com</div>
    </div>
</footer>
