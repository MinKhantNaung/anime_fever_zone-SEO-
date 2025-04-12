@section('description',
    'Discover the ultimate destination for anime enthusiasts! Dive into insightful reviews, engaging
    discussions, and a vibrant community at Anime Fever Zone. Join us and unleash your passion for anime today!')

    <div class="container mx-auto flex flex-wrap py-6">

        <section class="w-full md:w-2/3 flex flex-col px-3 overflow-hidden">

            <div class="my-3">
                <h3 class="text-4xl font-extrabold">Contact Anime Fever Zone</h3>
            </div>

            <div class="grid grid-cols-12">
                <div class="col-span-12 lg:col-span-6">
                    <div class="my-4">
                        <h3 class="text-3xl font-extrabold">General Inquiries</h3>
                        <p class="text-lg mt-5">
                            General Information, Feedback, Suggestions
                        </p>
                        <span class="text-lg mt-5 font-extrabold">
                            info@animefeverzone.com
                        </span>
                    </div>

                    <div class="my-4">
                        <h3 class="text-3xl font-extrabold">Editorial Inquiries</h3>
                        <p class="text-lg mt-5">
                            Topic Ideas, Feedback, Corrections or Suggestions
                        </p>
                        <span class="text-lg mt-5 font-extrabold">
                            info@animefeverzone.com
                        </span>
                    </div>

                    <div class="my-4">
                        <h3 class="text-3xl font-extrabold">Website Login</h3>
                        <p class="text-lg mt-5">
                            Account Issues or Questions
                        </p>
                        <span class="text-lg mt-5 font-extrabold">
                            info@animefeverzone.com
                        </span>
                    </div>
                </div>

                <div class="col-span-12 lg:col-span-6">
                    <div class="my-4">
                        <h3 class="text-3xl font-extrabold">Advertising</h3>
                        <p class="text-lg mt-5">
                            Display Advertising
                        </p>
                        <span class="text-lg mt-5 font-extrabold">
                            legal@animefeverzone.com
                        </span>
                    </div>

                    <div class="my-4">
                        <h3 class="text-3xl font-extrabold">Legal</h3>
                        <p class="text-lg mt-5">
                            Copyrights, Claims, Policy Inquiries
                        </p>
                        <span class="text-lg mt-5 font-extrabold">
                            legal@animefeverzone.com
                        </span>
                    </div>

                    <div class="mt-4">
                        <h3 class="text-3xl font-extrabold">Developer</h3>
                        <p class="text-lg mt-5">
                            Connect with our developer on LinkedIn.
                        </p>
                        <a href="https://www.linkedin.com/in/min-khant-naung-22226a25a/" target="_blank"
                            class="text-lg font-extrabold flex items-center">
                            <x-icons.linkedin-icon />
                            Min Khant Naung
                        </a>
                    </div>
                </div>
            </div>

        </section>

    </div>

@push('scripts')

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
@endpush
