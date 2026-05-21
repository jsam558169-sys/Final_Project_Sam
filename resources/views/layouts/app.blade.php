<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Source+Sans+Pro:wght@400;600&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-[#F5F7FA] text-[#0F1722]">
    <div class="min-h-screen">

        {{-- Navigation --}}
        <div class="bg-[#122B4F] border-b border-[#0B1A2F]">
            @include('layouts.navigation')
        </div>

        {{-- Page Heading --}}
        @isset($header)
        <header class="bg-white border-b border-[#CDD6E1] shadow-sm">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-[#122B4F] text-xl font-semibold">
                    {{ $header }}
                </h1>
            </div>
        </header>
        @endisset

        {{-- Page Content --}}
        <main class="bg-[#F5F7FA]">
            {{ $slot }}
        </main>

    </div>
</body>

</html>