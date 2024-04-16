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
    <livewire:components.topic-nav />

    <div>

        {{ $slot }}

    </div>

    <x-footer />

    @yield('scripts')

</body>

</html>
