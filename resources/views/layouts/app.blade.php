<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Style -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-900" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">

        <div
            x-show="sidebarOpen"
            @click="sidebarOpen = false"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm md:hidden"></div>

        <div
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 transition-transform duration-300 transform bg-white md:relative md:translate-x-0 md:flex flex-shrink-0">
            @include('layouts.sidebar')
        </div>

        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

            <header class="h-16 flex items-center justify-between px-4 bg-white border-b border-slate-100 md:hidden flex-shrink-0">
                <div class="flex items-center gap-3">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4">
                        <img src="{{ asset('images/logo-btm.png') }}" alt="Logo BTM" class="h-10 mx-auto md:h-10 w-auto object-contain">
                    </a>
                </div>
                <button @click="sidebarOpen = true" class="p-2 text-slate-500 hover:bg-slate-50 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </header>

            <main class="flex-1 overflow-y-auto p-4 md:p-8 focus:outline-none">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>