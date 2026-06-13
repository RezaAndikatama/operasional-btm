<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lacak Pesanan - PT. Briliant Teknik Mandiri</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="icon" type="image/png" href="{{ asset('images/logo-btm.png') }}?v=2">
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

    <div class="fixed inset-0 z-0 bg-slate-900" aria-hidden="true">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1504917595217-d4dc5ebe6122?q=80&w=2070&auto=format&fit=crop')] bg-cover bg-center opacity-25"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/80 via-slate-900/50 to-slate-900/90"></div>
    </div>

    <main class="relative z-10 max-w-xl mx-auto space-y-5">

        <header class="text-center mb-8 mt-4">
            <h1 class="text-3xl font-bold text-white drop-shadow-md tracking-tight">Lacak Pesanan Anda</h1>
            <p class="text-sm text-slate-300 mt-2">Masukkan Nomor Work Order untuk mengecek status saat ini</p>
        </header>

        <section aria-label="Pencarian Pesanan" class="bg-white rounded-2xl shadow-lg shadow-slate-900/20 p-5 border border-gray-100">
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

        // Logika Status Pembayaran
        $sisaBayar = $workOrder->total_cost - $workOrder->paid_amount;
        $isLunas = $sisaBayar <= 0;
            @endphp

            <section aria-label="Ringkasan Pesanan" class="bg-white rounded-2xl shadow-lg shadow-slate-900/20 p-5 border border-gray-100">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                <div class="w-full">
                    <div class="flex items-center gap-2 flex-wrap">
                        <h2 class="text-base font-bold text-gray-900">{{ $workOrder->wo_number }}</h2>
                        <span class="{{ $step4 ? 'bg-green-500' : ($step3 ? 'bg-orange-500' : 'bg-yellow-500') }} text-white text-[10px] uppercase tracking-wider font-bold px-2.5 py-0.5 rounded-full">
                            {{ $status }}
                        </span>
                    </div>
                    <time datetime="{{ $workOrder->created_at->toIso8601String() }}" class="text-xs text-gray-500 mt-1 block mb-3 border-b border-slate-100 pb-3">Dibuat pada {{ $workOrder->created_at->format('d M Y') }}</time>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-2">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Pelanggan</p>
                            <p class="text-xs font-semibold text-gray-800">{{ $workOrder->customer->company_name ?? 'Umum' }}</p>
                        </div>

                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Teknisi Yang Mengerjakan</p>
                            @if($workOrder->technician)
                            @php
                            // LOGIKA PENYAMARAN NAMA (MASKING)
                            // Memecah nama teknisi berdasarkan spasi
                            $nameParts = explode(' ', trim($workOrder->technician->name));
                            // Mengambil nama pertama
                            $publicName = $nameParts[0];
                            // Jika ada nama kedua, ambil hanya huruf pertamanya (inisial)
                            if (count($nameParts) > 1) {
                            $publicName .= ' ' . substr($nameParts[1], 0, 1) . '.';
                            }
                            @endphp
                            <div class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-700 bg-blue-50 px-2 py-0.5 rounded-md border border-blue-100" title="Nama disamarkan untuk privasi">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ $publicName }}
                            </div>
                            @else
                            <div class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md border border-slate-200">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Menunggu Penugasan
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            </section>

            <section aria-label="Informasi Tagihan dan Waktu" class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                <article class="bg-white rounded-2xl shadow-lg shadow-slate-900/20 p-5 border border-gray-100 flex items-center gap-4">
                    <div class="flex-shrink-0 w-11 h-11 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center border border-blue-100" aria-hidden="true">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Estimasi Selesai</h3>

                        @if($workOrder->estimasi_selesai)
                        <time datetime="{{ \Carbon\Carbon::parse($workOrder->estimasi_selesai)->toIso8601String() }}" class="text-sm font-bold text-gray-800 block">
                            {{ \Carbon\Carbon::parse($workOrder->estimasi_selesai)->translatedFormat('d F Y') }}
                        </time>
                        <p class="text-[10px] font-medium text-gray-500 mt-0.5">
                            {{ \Carbon\Carbon::parse($workOrder->estimasi_selesai)->diffForHumans() }}
                        </p>
                        @else
                        <p class="text-sm font-medium text-slate-800">
                            <span class="text-slate-400 italic">Belum ditentukan</span>
                        </p>
                        @endif

                    </div>
                </article>

                <article class="bg-white rounded-2xl shadow-lg shadow-slate-900/20 p-5 border border-gray-100 flex items-center gap-4">
                    @if($isLunas)
                    <div class="flex-shrink-0 w-11 h-11 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center border border-emerald-100" aria-hidden="true">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Status Tagihan</h3>
                        <span class="inline-block px-2 py-0.5 bg-emerald-100 text-emerald-700 text-[10px] font-bold uppercase tracking-wider rounded">LUNAS</span>
                    </div>
                    @else
                    <div class="flex-shrink-0 w-11 h-11 bg-amber-50 text-amber-600 rounded-full flex items-center justify-center border border-amber-100" aria-hidden="true">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Status Tagihan</h3>
                        <span class="inline-block px-2 py-0.5 bg-amber-100 text-amber-700 text-[10px] font-bold uppercase tracking-wider rounded mb-1">BELUM LUNAS</span>
                        <p class="text-[10px] font-medium text-gray-600">Sisa: <strong class="text-amber-600">Rp {{ number_format($sisaBayar, 0, ',', '.') }}</strong></p>
                    </div>
                    @endif
                </article>

            </section>

            <section aria-label="Progres Pengiriman" class="bg-white rounded-2xl shadow-lg shadow-slate-900/20 p-5 border border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900">Progres Pengerjaan</h3>
                <p class="text-xs text-gray-500 mt-0.5 mb-5 font-medium">{{ $workOrder->job_name }}</p>

                <div class="relative mb-6" aria-hidden="true">
                    <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-2 bg-green-500 rounded-full transition-all duration-1000 ease-out" @style(["width: $progressWidth"])></div>
                    </div>
                </div>

                <ol class="grid grid-cols-4 text-center" aria-label="Langkah pesanan">
                    <li class="flex flex-col items-center gap-1">
                        <span class="w-9 h-9 rounded-full {{ $step1 ? 'bg-green-500 text-white shadow-sm shadow-green-500/30' : 'bg-gray-100 text-gray-400' }} flex items-center justify-center transition-all" aria-hidden="true">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span class="text-[11px] font-bold {{ $step1 ? 'text-gray-800' : 'text-gray-400' }}">Diterima</span>
                    </li>

                    <li class="flex flex-col items-center gap-1">
                        <span class="w-9 h-9 rounded-full {{ $step2 ? 'bg-green-500 text-white shadow-sm shadow-green-500/30' : 'bg-gray-100 text-gray-400' }} flex items-center justify-center transition-all" aria-hidden="true">
                            @if($step2) <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            @else <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg> @endif
                        </span>
                        <span class="text-[11px] font-bold {{ $step2 ? 'text-gray-800' : 'text-gray-400' }}">Menunggu</span>
                    </li>

                    <li class="flex flex-col items-center gap-1">
                        <span class="w-9 h-9 rounded-full {{ $step3 ? 'bg-green-500 text-white shadow-sm shadow-green-500/30' : 'bg-gray-100 text-gray-400' }} flex items-center justify-center transition-all" aria-hidden="true">
                            @if($step3) <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            @else <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg> @endif
                        </span>
                        <span class="text-[11px] font-bold {{ $step3 ? 'text-gray-800' : 'text-gray-400' }}">Diproses</span>
                    </li>

                    <li class="flex flex-col items-center gap-1">
                        <span class="w-9 h-9 rounded-full {{ $step4 ? 'bg-green-500 text-white shadow-sm shadow-green-500/30' : 'bg-gray-100 text-gray-400' }} flex items-center justify-center transition-all" aria-hidden="true">
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

            <section aria-label="Riwayat Detail Pesanan" class="bg-white rounded-2xl shadow-lg shadow-slate-900/20 p-5 border border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900 mb-6">Detail Riwayat</h3>

                <ol class="space-y-0 relative">

                    <li class="timeline-item {{ $step2 ? 'done' : 'current' }} relative flex gap-4 pb-8">
                        <span class="relative z-10 mt-0.5 w-8 h-8 shrink-0 rounded-full {{ $step1 ? 'bg-green-500 text-white' : 'bg-gray-200' }} flex items-center justify-center" aria-hidden="true">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <div>
                            <p class="text-sm font-bold text-gray-900">Pesanan Diterima</p>
                            <p class="text-xs text-gray-500 mt-0.5">Sistem telah mencatat pesanan Anda.</p>
                            <time datetime="{{ $workOrder->created_at->toIso8601String() }}" class="text-[10px] font-semibold text-gray-400 mt-1.5 block">
                                {{ $workOrder->created_at->format('d M Y, H:i') }}
                            </time>
                        </div>
                    </li>

                    <li class="timeline-item {{ $step3 ? 'done' : ($step2 ? 'current' : '') }} relative flex gap-4 pb-8">
                        <span class="relative z-10 mt-0.5 w-8 h-8 shrink-0 rounded-full {{ $step2 ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-400' }} flex items-center justify-center" aria-hidden="true">
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
                            <p class="text-xs text-gray-500 mt-0.5">Admin sedang menjadwalkan pekerjaan.</p>
                        </div>
                    </li>

                    <li class="timeline-item {{ $step4 ? 'done' : ($step3 ? 'current' : '') }} relative flex gap-4 pb-8">
                        <span class="relative z-10 mt-0.5 w-8 h-8 shrink-0 rounded-full {{ $step3 ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-400' }} flex items-center justify-center" aria-hidden="true">
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

                    <li class="timeline-item relative flex gap-4">
                        <span class="relative z-10 mt-0.5 w-8 h-8 shrink-0 rounded-full {{ $step4 ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-400' }} flex items-center justify-center" aria-hidden="true">
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
            <section aria-label="Pesan Error" class="bg-red-50/95 backdrop-blur-sm rounded-2xl p-5 border border-red-200 text-center shadow-lg shadow-red-900/10">
                <h3 class="text-sm font-bold text-red-800">Pesanan Tidak Ditemukan</h3>
                <p class="text-xs text-red-600 mt-1">Pastikan Nomor Work Order yang Anda masukkan sudah benar.</p>
            </section>
            @endif
            @endif

    </main>

</body>

</html>