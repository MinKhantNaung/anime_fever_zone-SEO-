@section('title', 'Anime Fever Zone')
@section('description', 'Anime')

<div class="container mx-auto flex flex-wrap py-6">

    <!-- Posts Section -->
    <section class="w-full md:w-2/3 flex flex-col items-center px-3">
        <article class="flex flex-col shadow my-4">
            <!-- Article Image -->
            <a href="#" class="hover:opacity-75 w-full">
                <img src="https://source.unsplash.com/collection/1346951/1000x500?sig=2">
            </a>
            <div class="bg-white flex flex-col justify-start p-6">
                <!-- Topic and Tags -->
                <div>
                    | <a href="#" class="text-blue-700 text-sm font-bold uppercase pb-4 hover:underline">
                        Anime
                    </a>
                    | <a href="#" class="text-blue-700 text-sm font-bold uppercase pb-4 hover:underline">
                        Naruto Shippuden 2007
                    </a>
                </div>
                <!-- Heading -->
                <a href="#" class="text-3xl font-bold hover:text-gray-700 pb-4">Lorem Ipsum Dolor Sit Amet
                    Dolor Sit
                    Amet</a>
                <!-- Date -->
                <p href="#" class="text-sm pb-3">
                    By <a href="#" class="font-semibold hover:text-gray-800">David Grzyb</a>, Published on
                    January
                    12th, 2020
                </p>
                <!-- Brief Body -->
                <a href="#" class="pb-6">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus
                    quis porta
                    dui. Ut eu iaculis massa. Sed ornare ligula lacus, quis iaculis dui porta volutpat. In sit amet
                    posuere magna..</a>
                <a href="#" class="uppercase text-gray-800 hover:text-black">Continue Reading <i
                        class="fas fa-arrow-right"></i></a>
            </div>
        </article>

        <!-- Pagination -->
        <div class="flex items-center py-8">
            <a href="#"
                class="h-10 w-10 bg-blue-800 hover:bg-blue-600 font-semibold text-white text-sm flex items-center justify-center">1</a>
            <a href="#"
                class="h-10 w-10 font-semibold text-gray-800 hover:bg-blue-600 hover:text-white text-sm flex items-center justify-center">2</a>
            <a href="#"
                class="h-10 w-10 font-semibold text-gray-800 hover:text-gray-900 text-sm flex items-center justify-center ml-3">Next
                <i class="fas fa-arrow-right ml-2"></i></a>
        </div>
    </section>

    <!-- other posts Section -->
    <x-other-posts />

</div>
