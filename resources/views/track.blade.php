<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lacak Pesanan - PT. Briliant Teknik Mandiri</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Timeline connector line */
        .timeline-item:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 16px;
            top: 36px;
            width: 2px;
            height: calc(100% - 4px);
            background-color: #e5e7eb;
        }

        .timeline-item.done:not(:last-child)::after {
            background-color: #22c55e;
        }

        .timeline-item.current:not(:last-child)::after {
            background: linear-gradient(to bottom, #22c55e 60%, #e5e7eb 100%);
        }
    </style>
</head>

<body class="relative min-h-screen py-10 px-4 antialiased selection:bg-green-500 selection:text-white">

    <!-- BACKGROUND SECTION (Manufaktur Vibe) -->
    <div class="fixed inset-0 z-0 bg-slate-900">
        <!-- Gambar Background (Ganti URL ini dengan foto bengkel Anda jika ada) -->
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?q=80&w=2070&auto=format&fit=crop')] bg-cover bg-center opacity-25"></div>
        <!-- Gradient Overlay agar lebih elegan dan menyatu dengan konten -->
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/80 via-slate-900/50 to-slate-900/90"></div>
    </div>

    <!-- MAIN CONTENT CONTAINER -->
    <div class="relative z-10 max-w-xl mx-auto space-y-5">

        <!-- Page Header (Diubah menjadi warna putih agar kontras dengan background gelap) -->
        <header class="text-center mb-8 mt-4">
            <h1 class="text-3xl font-bold text-white drop-shadow-md tracking-tight">Lacak Pesanan Anda</h1>
            <p class="text-sm text-slate-300 mt-2">Masukkan Nomor Work Order untuk mengecek status saat ini</p>
        </header>

        <!-- Search Form -->
        <section aria-label="Order Search" class="bg-white rounded-2xl shadow-lg shadow-slate-900/20 p-5 border border-gray-100">
            <h2 class="text-sm font-semibold text-gray-700 mb-1">Cari Pesanan</h2>
            <p class="text-xs text-gray-400 mb-4">Masukkan ID pesanan Anda di bawah ini.</p>

            <form action="{{ route('cek-status') }}" method="GET">
                <div>
                    <label for="wo_number" class="block text-xs font-medium text-gray-600 mb-1">Nomor Work Order</label>
                    <input
                        type="text"
                        id="wo_number"
                        name="wo_number"
                        value="{{ request('wo_number') }}"
                        placeholder="Contoh: WO-2604-001"
                        required
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm text-gray-800 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition shadow-inner" />
                </div>

                <button
                    type="submit"
                    class="mt-4 w-full bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold py-3 rounded-xl flex items-center justify-center gap-2 transition-colors duration-200 shadow-md hover:shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
                    </svg>
                    Lacak Pesanan
                </button>
            </form>
        </section>

        @if(request()->has('wo_number'))
        @if($workOrder)

        @php
        // Logika Dinamis untuk Progres & Warna
        $status = $workOrder->status;

        $step1 = true; // Diterima (Selalu true jika ada di database)
        $step2 = in_array($status, ['Menunggu', 'Pending', 'Sedang Dikerjakan', 'Selesai']);
        $step3 = in_array($status, ['Sedang Dikerjakan', 'Selesai']);
        $step4 = $status == 'Selesai';

        $progressWidth = '0%';
        if ($step4) $progressWidth = '100%';
        elseif ($step3) $progressWidth = '66%';
        elseif ($step2) $progressWidth = '33%';
        @endphp

        <!-- Order Summary -->
        <section aria-label="Order Summary" class="bg-white rounded-2xl shadow-lg shadow-slate-900/20 p-5 border border-gray-100">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <h2 class="text-base font-bold text-gray-900">{{ $workOrder->wo_number }}</h2>
                        <span class="{{ $step4 ? 'bg-green-500' : ($step3 ? 'bg-orange-500' : 'bg-yellow-500') }} text-white text-[10px] uppercase tracking-wider font-bold px-2.5 py-0.5 rounded-full">
                            {{ $status }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Dibuat pada {{ $workOrder->created_at->format('d M Y') }}</p>
                    <p class="text-xs font-semibold text-gray-700 mt-2">Pelanggan: {{ $workOrder->customer->company_name ?? 'Umum' }}</p>
                </div>
            </div>
        </section>

        <!-- Delivery Progress -->
        <section aria-label="Delivery Progress" class="bg-white rounded-2xl shadow-lg shadow-slate-900/20 p-5 border border-gray-100">
            <h3 class="text-sm font-semibold text-gray-900">Progres Pengerjaan</h3>
            <p class="text-xs text-gray-500 mt-0.5 mb-5 font-medium">{{ $workOrder->job_name }}</p>

            <!-- Progress Bar -->
            <div class="relative mb-6">
                <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-2 bg-green-500 rounded-full transition-all duration-1000 ease-out" @style(["width: $progressWidth"])></div>
                </div>
            </div>

            <!-- Steps (Horizontal) -->
            <ol class="grid grid-cols-4 text-center" aria-label="Order steps">
                <!-- Step 1: Diterima -->
                <li class="flex flex-col items-center gap-1">
                    <span class="w-9 h-9 rounded-full {{ $step1 ? 'bg-green-500 text-white shadow-sm shadow-green-500/30' : 'bg-gray-100 text-gray-400' }} flex items-center justify-center transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </span>
                    <span class="text-[11px] font-bold {{ $step1 ? 'text-gray-800' : 'text-gray-400' }}">Diterima</span>
                </li>

                <!-- Step 2: Menunggu -->
                <li class="flex flex-col items-center gap-1">
                    <span class="w-9 h-9 rounded-full {{ $step2 ? 'bg-green-500 text-white shadow-sm shadow-green-500/30' : 'bg-gray-100 text-gray-400' }} flex items-center justify-center transition-all">
                        @if($step2) <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        @else <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg> @endif
                    </span>
                    <span class="text-[11px] font-bold {{ $step2 ? 'text-gray-800' : 'text-gray-400' }}">Menunggu</span>
                </li>

                <!-- Step 3: Proses -->
                <li class="flex flex-col items-center gap-1">
                    <span class="w-9 h-9 rounded-full {{ $step3 ? 'bg-green-500 text-white shadow-sm shadow-green-500/30' : 'bg-gray-100 text-gray-400' }} flex items-center justify-center transition-all">
                        @if($step3) <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        @else <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg> @endif
                    </span>
                    <span class="text-[11px] font-bold {{ $step3 ? 'text-gray-800' : 'text-gray-400' }}">Diproses</span>
                </li>

                <!-- Step 4: Selesai -->
                <li class="flex flex-col items-center gap-1">
                    <span class="w-9 h-9 rounded-full {{ $step4 ? 'bg-green-500 text-white shadow-sm shadow-green-500/30' : 'bg-gray-100 text-gray-400' }} flex items-center justify-center transition-all">
                        @if($step4) <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        @else <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg> @endif
                    </span>
                    <span class="text-[11px] font-bold {{ $step4 ? 'text-gray-800' : 'text-gray-400' }}">Selesai</span>
                </li>
            </ol>
        </section>

        <!-- Order Timeline (Vertical) -->
        <section aria-label="Order Timeline" class="bg-white rounded-2xl shadow-lg shadow-slate-900/20 p-5 border border-gray-100">
            <h3 class="text-sm font-semibold text-gray-900 mb-6">Detail Riwayat</h3>

            <ol class="space-y-0 relative" aria-label="Order history">

                <!-- Step 1: Diterima -->
                <li class="timeline-item {{ $step2 ? 'done' : 'current' }} relative flex gap-4 pb-8">
                    <span class="relative z-10 mt-0.5 w-8 h-8 shrink-0 rounded-full {{ $step1 ? 'bg-green-500 text-white' : 'bg-gray-200' }} flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </span>
                    <div>
                        <p class="text-sm font-bold text-gray-900">Pesanan Diterima</p>
                        <p class="text-xs text-gray-500 mt-0.5">Sistem telah mencatat pesanan Anda.</p>
                        <time class="text-[10px] font-semibold text-gray-400 mt-1.5 block">{{ $workOrder->created_at->format('d M Y, H:i') }}</time>
                    </div>
                </li>

                <!-- Step 2: Menunggu -->
                <li class="timeline-item {{ $step3 ? 'done' : ($step2 ? 'current' : '') }} relative flex gap-4 pb-8">
                    <span class="relative z-10 mt-0.5 w-8 h-8 shrink-0 rounded-full {{ $step2 ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-400' }} flex items-center justify-center">
                        @if($step2) <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        @else <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg> @endif
                    </span>
                    <div>
                        <div class="flex items-center gap-2">
                            <p class="text-sm font-bold {{ $step2 ? 'text-gray-900' : 'text-gray-400' }}">Menunggu Penugasan</p>
                            @if($status == 'Menunggu' || $status == 'Pending') <span class="bg-orange-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm shadow-orange-500/30">Saat ini</span> @endif
                        </div>
                        <p class="text-xs text-gray-500 mt-0.5">Admin sedang menjadwalkan pekerjaan ke teknisi.</p>
                    </div>
                </li>

                <!-- Step 3: Proses -->
                <li class="timeline-item {{ $step4 ? 'done' : ($step3 ? 'current' : '') }} relative flex gap-4 pb-8">
                    <span class="relative z-10 mt-0.5 w-8 h-8 shrink-0 rounded-full {{ $step3 ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-400' }} flex items-center justify-center">
                        @if($step3) <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        @else <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg> @endif
                    </span>
                    <div>
                        <div class="flex items-center gap-2">
                            <p class="text-sm font-bold {{ $step3 ? 'text-gray-900' : 'text-gray-400' }}">Sedang Dikerjakan</p>
                            @if($status == 'Sedang Dikerjakan') <span class="bg-orange-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm shadow-orange-500/30">Saat ini</span> @endif
                        </div>
                        <p class="text-xs text-gray-500 mt-0.5">Teknisi sedang melakukan proses manufaktur dan perbaikan.</p>
                    </div>
                </li>

                <!-- Step 4: Selesai -->
                <li class="timeline-item relative flex gap-4">
                    <span class="relative z-10 mt-0.5 w-8 h-8 shrink-0 rounded-full {{ $step4 ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-400' }} flex items-center justify-center">
                        @if($step4) <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        @else <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg> @endif
                    </span>
                    <div>
                        <div class="flex items-center gap-2">
                            <p class="text-sm font-bold {{ $step4 ? 'text-gray-900' : 'text-gray-400' }}">Selesai</p>
                            @if($status == 'Selesai') <span class="bg-green-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm shadow-green-500/30">Selesai</span> @endif
                        </div>
                        <p class="text-xs {{ $step4 ? 'text-gray-500' : 'text-gray-400' }} mt-0.5">Pekerjaan telah rampung dan siap diserahterimakan.</p>
                    </div>
                </li>

            </ol>
        </section>
        @else
        <!-- Jika WO Tidak Ditemukan -->
        <section class="bg-red-50/95 backdrop-blur-sm rounded-2xl p-5 border border-red-200 text-center shadow-lg shadow-red-900/10">
            <h3 class="text-sm font-bold text-red-800">Pesanan Tidak Ditemukan</h3>
            <p class="text-xs text-red-600 mt-1">Pastikan Nomor Work Order yang Anda masukkan sudah benar.</p>
        </section>
        @endif
        @endif

    </div>

</body>

</html>