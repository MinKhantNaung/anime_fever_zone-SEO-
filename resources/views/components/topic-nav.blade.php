<nav class="w-full py-4 border-t border-b bg-gray-100" x-data="{ open: false }">
    <div class="block sm:hidden">
        <a href="#"
            class="block md:hidden text-base font-bold uppercase text-center justify-center items-center"
            @click="open = !open">
            Topics <i :class="open ? 'fa-chevron-down' : 'fa-chevron-up'" class="fas ml-2"></i>
        </a>
    </div>
    <div :class="open ? 'block' : 'hidden'" class="w-full flex-grow sm:flex sm:items-center sm:w-auto">
        <div
            class="w-full container mx-auto flex flex-col sm:flex-row items-center justify-center text-sm font-bold uppercase mt-0 px-6 py-2">
            <a href="#"
                class="hover:bg-gradient-to-r hover:from-[#9926f0] hover:to-[#d122e3] rounded py-2 px-4 mx-2">Anime</a>
            <a href="#"
                class="hover:bg-gradient-to-r hover:from-[#9926f0] hover:to-[#d122e3] rounded py-2 px-4 mx-2">Tags</a>
            <a href="#"
                class="hover:bg-gradient-to-r hover:from-[#9926f0] hover:to-[#d122e3] rounded py-2 px-4 mx-2">Topics(Blogger)</a>
            <a href="#"
                class="hover:bg-gradient-to-r hover:from-[#9926f0] hover:to-[#d122e3] rounded py-2 px-4 mx-2">Tags(Blogger)</a>
            <a href="#"
                class="hover:bg-gradient-to-r hover:from-[#9926f0] hover:to-[#d122e3] rounded py-2 px-4 mx-2">Posts(Blogger)</a>
        </div>
    </div>
</nav>
