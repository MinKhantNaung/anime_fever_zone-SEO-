<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Anime Fever Zone' }}</title>

    <meta name="description" content="@yield('description')">

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
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
            <a wire:navigate.hover href="{{ route('home') }}" class="font-bold text-gray-800 uppercase hover:text-gray-700 text-3xl sm:text-5xl">
                Anime Fever Zone
            </a>
            <p class="text-lg text-gray-600 px-2">
                Embark on a Journey through the Anime Universe and Beyond! Dive into a World of Anime and More.
            </p>
        </div>
    </header>

    <!-- Topic Nav -->
    <livewire:components.topic-nav />

    <div class="min-h-screen">

        {{ $slot }}

    </div>

    <x-footer />

    @livewire('wire-elements-modal')

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('swal', (event) => {
                // console.log(event)
                Swal.fire({
                    title: event[0].title,
                    icon: event[0].icon,
                    iconColor: event[0].iconColor,
                    timer: 3000,
                    toast: true,
                    position: 'top-right',
                    timerProgressBar: true,
                    showConfirmButton: false
                });
            });

            Livewire.on('subscribed', (event) => {
                // console.log(event)
                Swal.fire({
                    title: event[0].title,
                    icon: event[0].icon,
                    iconColor: event[0].iconColor,
                    timer: 20000,
                    toast: true,
                    position: 'top',
                    timerProgressBar: true,
                    showConfirmButton: false
                });
            });
        })
    </script>

    @yield('script')
</body>

</html>
