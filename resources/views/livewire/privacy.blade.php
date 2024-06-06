@section('description', 'Privacy Policy')

<div class="container mx-auto flex flex-wrap py-6">

    <section class="w-full md:w-2/3 flex flex-col px-3 overflow-hidden">

        <div class="my-3">
            <h3 class="text-3xl font-extrabold">Privacy Policy</h3>
            <p class="text-lg font-medium mt-5">
                Last updated: 7-June-2024
                <br><br>
                Welcome to Anime Fever Zone! We are committed to protecting your privacy and ensuring that your
                personal information is handled responsibly. This Privacy Policy outlines how we collect, use, and
                safeguard your information when you visit our website.
            </p>
        </div>

        <div class="my-3">
            <h3 class="text-3xl font-extrabold">Information We Collect</h3>
            <p class="text-lg font-medium mt-5">
                When you visit our website, we may collect certain information about you, including:
                <br>
            <ul class="list-none">
                {{-- <li>
                    Personal information provided voluntarily, such as your name and email address when subscribing to
                    our newsletter or commenting on posts.
                </li> --}}
                <li>
                    Automatically collected information, such as your IP address, browser type, and device
                    characteristics, through cookies and similar tracking technologies.
                </li>
            </ul>
            </p>
        </div>

        <div class="my-3">
            <h3 class="text-3xl font-extrabold">Use of Information</h3>
            <p class="text-lg font-medium mt-5">
                We use the information we collect for the following purposes:
                <br>
            <ul class="list-none">
                <li>
                    To personalize your experience and improve our website's functionality.
                </li>
                {{-- <li>
                    To communicate with you, including sending newsletters and responding to inquiries.
                </li> --}}
                <li>
                    To analyze trends and gather demographic information for internal purposes.
                </li>
                <li>
                    To comply with legal obligations and protect our rights.
                </li>
            </ul>
            </p>
        </div>

        <div class="my-3">
            <h3 class="text-3xl font-extrabold">Third-Party Disclosure</h3>
            <p class="text-lg font-medium mt-5">
                We do not sell, trade, or otherwise transfer your personal information to third parties without your
                consent. However, we may share non-personally identifiable information with trusted third parties for
                marketing, advertising, or analytics purposes.
            </p>
        </div>

        <div class="my-3">
            <h3 class="text-3xl font-extrabold">Data Security</h3>
            <p class="text-lg font-medium mt-5">
                We implement a variety of security measures to safeguard your personal information, including encryption
                and secure server connections. However, no method of transmission over the internet or electronic
                storage is 100% secure, and we cannot guarantee absolute security.
            </p>
        </div>

        <div class="my-3">
            <h3 class="text-3xl font-extrabold">Your Rights</h3>
            <p class="text-lg font-medium mt-5">
                You have the right to access, update, or delete your personal information. If you would like to exercise
                these rights or have any questions about our privacy practices, please contact us at
                (minkhantnaungkzw@gmail.com).
            </p>
        </div>

        <div class="my-3">
            <h3 class="text-3xl font-extrabold">Legal Basis for Processing</h3>
            <p class="text-lg font-medium mt-5">
                We process personal data based on your consent or our legitimate interests in providing and improving
                our services. You may withdraw your consent or object to processing at any time by contacting us.
            </p>
        </div>

        <div class="my-3">
            <h3 class="text-3xl font-extrabold">Updates to this Policy</h3>
            <p class="text-lg font-medium mt-5">
                We may update this Privacy Policy from time to time to reflect changes in our practices or legal
                requirements. Any updates will be posted on this page, with the last updated date indicated at the top.
            </p>
        </div>

        <div class="my-3">
            <h3 class="text-3xl font-extrabold">Contact Us</h3>
            <p class="text-lg font-medium mt-5">
                If you have any questions or concerns about this Privacy Policy or our data practices, please contact us
                at dowhatyoulikeknm@gmail.com.
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
          "description": "Privacy Policy",
          "author": {
            "@type": "Person",
            "name": "Anime Fever Zone"
          }
        }
        </script>
@endsection
