@section('description',
    'Discover the ultimate destination for anime enthusiasts! Dive into insightful reviews, engaging
    discussions, and a vibrant community at Anime Fever Zone. Join us and unleash your passion for anime today!')

    <div class="container mx-auto flex flex-wrap py-6">

        <section class="w-full md:w-2/3 flex flex-col px-3 overflow-hidden">

            <div class="my-3">
                <h3 class="text-3xl font-extrabold">Welcome to Anime Fever Zone!</h3>
                <p class="text-lg font-medium mt-5">Unleash Your Passion for Anime</p>
            </div>

            <div class="my-3">
                <h3 class="text-3xl font-extrabold">Who I am:</h3>
                <p class="text-lg font-medium mt-5">
                    Hey there, fellow anime enthusiasts! I'm Min Khant Naung, the sole developer and writer behind Anime
                    Fever
                    Zone (Tech - Laravel 10, Livewire 3, Alpine). This blog isn't just a project for me; it's a labor of love fueled by my deep passion for all
                    things anime.
                </p>
            </div>

            <div class="my-3">
                <h3 class="text-3xl font-extrabold">My Mission:</h3>
                <p class="text-lg font-medium mt-5">
                    Here at Anime Fever Zone, my mission is simple: to share my enthusiasm for anime with fellow fans like
                    you. Through my personal insights, reviews, and analyses, I aim to create a space where we can come
                    together to celebrate and explore the captivating world of anime.
                </p>
            </div>

            <div class="my-3">
                <h3 class="text-3xl font-extrabold">What I Offer:</h3>
                <p class="text-lg font-medium mt-5">
                    <span class="font-extrabold text-xl">Personal Reviews:</span> Dive into my personal take on the latest
                    anime releases and timeless classics. From
                    dissecting plot twists to gushing over favorite characters, I'll take you on a journey through the shows
                    that have captured my heart.
                </p>
                {{-- <p class="text-lg font-medium mt-5">
                    <span class="font-extrabold text-xl">Thoughts and Musings:</span> Join me as I delve into the latest trends, controversies, and discussions within
                    the anime community. From thought-provoking editorials to lighthearted reflections, there's always
                    something new to explore.
                </p>
                <p class="text-lg font-medium mt-5">
                    <span class="font-extrabold text-xl">Community Connection:</span> While it's just me behind the scenes, I still want to hear from you! Share your
                    thoughts and opinions in the comments section, or connect with me on social media to join the
                    conversation.
                </p> --}}
            </div>

            {{-- <div class="my-3">
                <h3 class="text-3xl font-extrabold">Join Me:</h3>
                <p class="text-lg font-medium mt-5">
                    Are you ready to dive deep into the world of anime with a fellow fan? Subscribe to Anime Fever Zone to
                    stay updated on my latest posts and musings. Whether you're looking for recommendations, analysis, or
                    just a friendly chat about your favorite shows, you'll find it here.
                </p>
            </div> --}}

            <div class="my-3">
                <h3 class="text-3xl font-extrabold">Connect With Me:</h3>
                <p class="text-lg font-medium mt-5">
                    Shoot me an email at (minkhantnaung839@gmail.com) if you have any questions, suggestions, or just want
                    to
                    chat
                    one-on-one.
                </p>
            </div>

            <div class="my-3">
                <h3 class="text-3xl font-extrabold">Let's Explore Together:</h3>
                <p class="text-lg font-medium mt-5">
                    Anime has a way of bringing people together, and I'm excited to embark on this journey with you. So grab
                    your favorite snack, cozy up with your plushies, and let's dive into the wonderful world of anime
                    together here at Anime Fever Zone.
                </p>
            </div>

        </section>

    </div>

@section('scripts')
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "BlogPosting",
          "headline": "Anime Fever Zone",
          "image": "{{ asset('favicon.ico') }}",
          "description": "Explore the latest news, reviews, and discussions on anime and other popular series at Anime Fever Zone. Stay up-to-date
          with the hottest trends and join our vibrant community of anime enthusiasts.",
          "author": {
            "@type": "Person",
            "name": "Anime Fever Zone"
          }
        }
        </script>
@endsection
