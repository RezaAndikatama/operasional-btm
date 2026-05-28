<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Bengkel BTM') }} - Login</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo-btm.png') }}?v=2">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="font-sans text-slate-900 antialiased h-screen overflow-hidden flex bg-white">

    <div class="hidden lg:flex lg:w-1/2 relative bg-slate-900 overflow-hidden">

        <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80"
            alt="Workshop Background"
            class="absolute inset-0 w-full h-full object-cover opacity-30 mix-blend-luminosity">

        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/80 to-transparent"></div>

        <div class="relative z-10 flex flex-col justify-center items-center text-center p-12 lg:p-20 w-full h-full text-white">

            <div class="flex justify-center items-center gap-3 mb-6">
                <span class="text-xl font-medium tracking-widest text-slate-300">PT Briliant Teknik Mandiri</span>
            </div>

            <div class="max-w-xl flex flex-col items-center">
                <h1 class="text-4xl lg:text-5xl font-bold leading-tight mb-6">
                    Sistem Informasi Operasional
                </h1>
                <p class="text-lg text-slate-300 font-light leading-relaxed">
                    Sistem yang dibuat untuk mengelola Transaksi, Memantau inventori, dan mengoptimalkan kinerja PT. Briliant Teknik Mandiri.
                </p>
            </div>
        </div>
    </div>

    <div class="w-full lg:w-1/2 h-full flex flex-col justify-center items-center bg-white px-8 sm:px-12 lg:px-24">
        <div class="w-full max-w-md">
            {{ $slot }}
        </div>
    </div>

</body>

</html>