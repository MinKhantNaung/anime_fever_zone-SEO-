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
                            edit@animefeverzone.com
                        </span>
                    </div>

                    <div class="my-4">
                        <h3 class="text-3xl font-extrabold">Website Login</h3>
                        <p class="text-lg mt-5">
                            Account Issues or Questions
                        </p>
                        <span class="text-lg mt-5 font-extrabold">
                            minkhantnaung839@gmail.com
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
                            minkhantnaung839@gmail.com
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-linkedin mr-1" viewBox="0 0 16 16">
                                <path
                                    d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.934c0 .694.521 1.248 1.327 1.248zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016l.016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225z" />
                            </svg>
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
