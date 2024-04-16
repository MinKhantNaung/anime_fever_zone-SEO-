<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <meta name="description" content="@yield('description')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white font-family-karla">

    <!-- Top Bar Nav -->
    <x-nav-bar />

    <!-- Text Header -->
    <header class="w-full container mx-auto">
        <div class="flex flex-col items-center py-12">
            <a class="font-bold text-gray-800 uppercase hover:text-gray-700 text-3xl sm:text-5xl" href="#">
                Anime Fever Zone
            </a>
            <p class="text-lg text-gray-600">
                Embark on a Journey through the Anime Universe and Beyond! Dive into a World of Anime and More.
            </p>
        </div>
    </header>

    <!-- Topic Nav -->
    <x-topic-nav />


    <div>

        {{ $slot }}

    </div>

    <footer class="w-full border-t pb-12 shadow bg-gradient-to-r from-[#9926f0] to-[#d122e3] text-white">
        <div class="w-full container mx-auto flex flex-col items-center">
            <div class="flex flex-col md:flex-row text-center md:text-left md:justify-between py-6">
                <a href="#" class="uppercase px-3 hover:text-gray-200 hover:underline">About</a>
                <a href="#" class="uppercase px-3 hover:text-gray-200 hover:underline">Privacy Policy</a>
                <a href="#" class="uppercase px-3 hover:text-gray-200 hover:underline">Terms & Conditions</a>
                <a href="#" class="uppercase px-3 hover:text-gray-200 hover:underline">Contact Us</a>
            </div>
            <div class="uppercase pb-6">&copy; animefeverzone.com</div>
        </div>
    </footer>

</body>

</html>
