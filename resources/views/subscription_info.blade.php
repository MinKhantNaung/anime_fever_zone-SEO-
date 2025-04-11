<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Subscription: Anime Fever Zone</title>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="grid grid-cols-12 mt-5">
        <div class="col-span-12 mb-2">
            <img src="{{ asset('favicon.ico') }}" alt="anime_fever_zone_logo" class="w-[200px] h-[200px] mx-auto">
        </div>
        <div class="col-span-12 md:col-span-4"></div>
        <div class="col-span-12 md:col-span-4">
            @if ($info == 'success')
                <div role="alert" class="alert alert-info w-full">
                    <x-icons.tick-icon />
                    <span>
                        Thank you for subscribing to Anime Fever Zone. You are successfully verified as a subscriber
                        to Anime Fever Zone. Now, you can close this
                        page.
                    </span>
                </div>
            @elseif($info == 'error')
                <div role="alert" class="alert alert-error w-full">
                    <x-icons.cross-icon />
                    <span>Sorry, Try again later !</span>
                </div>
            @endif
        </div>
    </div>
</body>

</html>
