<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} Admin</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo-btm.png') }}?v=2">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-900" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">

        <div x-show="sidebarOpen"
            @click="sidebarOpen = false"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm md:hidden" style="display: none;"></div>

        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="print:hidden fixed inset-y-0 left-0 z-50 w-64 transition-transform duration-300 transform bg-white md:relative md:translate-x-0 md:flex flex-shrink-0">
            @include('layouts.sidebar')
        </div>

        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

            <header class="print:hidden h-16 flex items-center justify-between bg-white border-b border-slate-100 px-4 sm:px-6 lg:px-8 flex-shrink-0 z-10 font-poppins">

                <div class="flex items-center gap-4">

                    <div class="flex items-center gap-3 md:hidden">
                        <button @click="sidebarOpen = true" class="p-2 -ml-2 text-slate-500 hover:bg-slate-50 rounded-lg transition-colors focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                            </svg>
                        </button>
                        <a href="{{ route('dashboard') }}" class="flex items-center">
                            <img src="{{ asset('images/logo-btm.png') }}" alt="Logo BTM" class="h-8 w-auto object-contain">
                        </a>
                    </div>

                    <div class="hidden md:flex items-center">
                        @php
                        date_default_timezone_set('Asia/Jakarta');
                        $hour = date('H');
                        if ($hour >= 5 && $hour < 12) { $greeting='Selamat pagi' ; }
                            elseif ($hour>= 12 && $hour < 15) { $greeting='Selamat siang' ; }
                                elseif ($hour>= 15 && $hour < 18) { $greeting='Selamat sore' ; }
                                    else { $greeting='Selamat malam' ; }

                                    $firstName=explode(' ', Auth::user()->name)[0] ?? ' User';
                                    @endphp
                                    <h2 class="text-xl tracking-tight">
                                    <span class="text-slate-600 font-medium">{{ $greeting }},</span>
                                    <span class="text-emerald-800 font-bold ml-1">{{ $firstName }}!</span>
                                    </h2>
                    </div>
                </div>

                <div class="flex items-center gap-3 sm:gap-6">

                    <button class="relative p-2 text-slate-500 hover:text-slate-700 transition-colors rounded-full hover:bg-slate-50 focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span class="absolute top-1.5 right-1.5 block w-2 h-2 rounded-full bg-orange-500 ring-2 ring-white"></span>
                    </button>

                    <div class="hidden sm:block w-px h-8 bg-slate-200"></div>

                    <div x-data="{ profileOpen: false }" class="relative z-50">
                        <button @click="profileOpen = !profileOpen" @click.away="profileOpen = false" class="flex items-center gap-3 focus:outline-none hover:bg-slate-50 p-1.5 rounded-xl transition-colors">

                            <div class="hidden sm:flex flex-col items-end text-right">
                                <span class="text-sm font-semibold text-slate-700 leading-tight">{{ Auth::user()->name }}</span>
                                <span class="text-[11px] font-medium text-slate-500 mt-0.5 capitalize">
                                    {{ Auth::user()->roles->first()->name ?? 'Administrator' }}
                                </span>
                            </div>

                            <svg class="w-4 h-4 text-slate-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>

                            <div class="relative">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=047857&color=fff&bold=true"
                                    alt="Profile"
                                    class="w-9 h-9 rounded-full border border-slate-100 object-cover shadow-sm">
                                <span class="absolute bottom-0 right-0 block w-2.5 h-2.5 rounded-full bg-green-500 ring-2 ring-white"></span>
                            </div>
                        </button>

                        <div x-show="profileOpen"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 py-1" style="display: none;">

                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:text-emerald-500 font-sm transition-colors">
                                Pengaturan Profil
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-4 md:p-8 print:p-0 focus:outline-none">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>