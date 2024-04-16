<aside class="w-full md:w-1/3 flex flex-col items-center px-3">

    @if (request()->routeIs('post.home'))
        <div class="w-full">
            <span class="bg-rose-500">.</span>
            <span class="text-2xl">You may also like</span>
        </div>
    @else
        <div class="w-full">
            <span class="bg-rose-500">.</span>
            <span class="text-2xl">Latest</span>
        </div>
    @endif

    <div class="grid grid-cols-12 bg-white shadow my-4 p-6">
        <div class="col-span-12 lg:col-span-4">
            <img src="https://source.unsplash.com/collection/1346951/1000x500?sig=3" class="w-full object-cover">
        </div>
        <div class="col-span-12 lg:col-span-8">
            <p class="px-2 font-bold hover:underline">Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                Amet illo est dolores nulla </p>
        </div>
    </div>
    <div class="grid grid-cols-12 bg-white shadow my-4 p-6">
        <div class="col-span-12 lg:col-span-4">
            <img src="https://source.unsplash.com/collection/1346951/1000x500?sig=3" class="w-full object-cover">
        </div>
        <div class="col-span-12 lg:col-span-8">
            <p class="px-2 font-bold hover:underline">Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                Amet illo est dolores nulla </p>
        </div>
    </div>
    <div class="grid grid-cols-12 bg-white shadow my-4 p-6">
        <div class="col-span-12 lg:col-span-4">
            <img src="https://source.unsplash.com/collection/1346951/1000x500?sig=3" class="w-full object-cover">
        </div>
        <div class="col-span-12 lg:col-span-8">
            <p class="px-2 font-bold hover:underline">Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                Amet illo est dolores nulla </p>
        </div>
    </div>

</aside>
