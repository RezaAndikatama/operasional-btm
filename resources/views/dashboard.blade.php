<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto font-poppins">

        <!-- HEADER DASHBOARD -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Dashboard Operasional</h1>
                <p class="text-sm text-slate-500 mt-1">Ringkasan aktivitas pencatatan harian PT. Briliant Teknik Mandiri.</p>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-6">

            <!-- KOLOM UTAMA -->
            <div class="col-span-12 xl:col-span-8 space-y-6">

                <section aria-label="Ringkasan Operasional" class="flex flex-wrap -mx-2 sm:-mx-3 mb-4">

                    {{-- CARD: Total WO Aktif --}}
                    <div class="w-full lg:w-1/2 px-2 sm:px-3 mb-4 sm:mb-6 flex">
                        <article class="w-full bg-gradient-to-br from-slate-900 to-slate-800 text-white p-6 sm:p-8 rounded-3xl shadow-xl shadow-slate-900/20 relative overflow-hidden flex flex-col justify-between min-h-[12rem]">
                            <div class="relative z-10">
                                <p class="text-sm font-medium text-slate-300">Selamat Datang,</p>
                                <h2 class="text-xl md:text-2xl font-semibold mt-1 tracking-wide truncate">{{ Auth::user()->name ?? 'Admin Operasional' }}</h2>
                            </div>

                            <div class="relative z-10 mt-8">
                                <p class="text-[10px] uppercase tracking-widest text-emerald-400 font-semibold mb-1">Total WO Aktif</p>
                                <div class="flex items-end gap-2">
                                    <p class="text-4xl md:text-5xl font-bold">{{ $totalWoAktif ?? 0 }}</p>
                                    <span class="text-sm text-slate-400 font-medium mb-1">Pekerjaan</span>
                                </div>
                            </div>

                            <div aria-hidden="true" class="absolute -right-8 -bottom-8 w-32 h-32 bg-emerald-500/20 rounded-full blur-2xl"></div>
                            <div aria-hidden="true" class="absolute right-4 top-4 opacity-20">
                                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                        </article>
                    </div>

                    {{-- CARD: Total Pemasukan --}}
                    <div class="w-full lg:w-1/2 px-2 sm:px-3 mb-4 sm:mb-6 flex">
                        <article style="background: linear-gradient(135deg, #10b981, #059669, #0f766e);" class="w-full text-white p-6 sm:p-8 rounded-3xl shadow-xl relative overflow-hidden flex flex-col justify-between min-h-[12rem]">

                            {{-- Decorative background elements --}}
                            <div aria-hidden="true" class="absolute inset-0 overflow-hidden pointer-events-none">
                                <div class="absolute -right-10 -top-10 w-48 h-48 rounded-full blur-3xl" style="background: rgba(255,255,255,0.1);"></div>
                                <div class="absolute -left-6 -bottom-10 w-40 h-40 rounded-full blur-2xl" style="background: rgba(17,94,89,0.4);"></div>
                                <div class="absolute right-16 bottom-4 w-20 h-20 rounded-full blur-xl" style="background: rgba(110,231,183,0.2);"></div>
                                {{-- Dot pattern --}}
                                <svg class="absolute inset-0 w-full h-full" style="opacity: 0.05;" xmlns="http://www.w3.org/2000/svg">
                                    <defs>
                                        <pattern id="dots-income" x="0" y="0" width="16" height="16" patternUnits="userSpaceOnUse">
                                            <circle cx="2" cy="2" r="1.5" fill="white" />
                                        </pattern>
                                    </defs>
                                    <rect width="100%" height="100%" fill="url(#dots-income)" />
                                </svg>
                            </div>

                            {{-- Header: Icon + Badge --}}
                            <div class="relative z-10 flex justify-between items-start">
                                <div class="p-3 rounded-2xl w-fit shadow-inner" style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.2);">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>

                            {{-- Main Content --}}
                            <div class="relative z-10 mt-5">
                                <p class="text-[11px] uppercase tracking-widest font-semibold mb-2" style="color: rgba(209,250,229,0.8);">Total Pemasukan</p>

                                <p class="text-3xl md:text-4xl font-bold tracking-tight leading-none">
                                    Rp {{ number_format($totalPemasukan ?? 0, 0, ',', '.') }}
                                </p>

                                {{-- Divider --}}
                                <div class="mt-5 h-px" style="background: linear-gradient(to right, rgba(255,255,255,0.2), rgba(255,255,255,0.05), transparent);"></div>

                                {{-- Footer stat --}}
                                <div class="mt-4 flex items-center justify-between">
                                    <div class="flex items-center gap-2 text-[12px]" style="color: rgba(209,250,229,0.7);">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Pemasukan Keseluruhan Bulan Ini
                                    </div>
                                </div>
                            </div>

                        </article>
                    </div>

                    {{-- CARD: Status Pending --}}
                    <div class="w-1/2 lg:w-1/4 px-2 sm:px-3 mb-4 sm:mb-6 flex">
                        <article class="w-full bg-white p-4 sm:p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col justify-between">
                            <header class="flex justify-between items-start mb-4 sm:mb-0">
                                <div aria-hidden="true" class="p-2 sm:p-3 bg-amber-50 rounded-2xl text-amber-500 w-fit">
                                    <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </header>
                            <div class="mt-auto">
                                <p class="text-[11px] sm:text-sm font-medium text-slate-500">Status Pending</p>
                                <p class="text-2xl sm:text-3xl font-bold text-slate-800 mt-1">{{ $statusPending ?? 0 }}</p>
                                <div class="mt-2 w-fit inline-flex items-center text-[9px] sm:text-xs font-medium text-amber-600 bg-amber-50 px-2 sm:px-2.5 py-1 rounded-lg">Menunggu</div>
                            </div>
                        </article>
                    </div>

                    {{-- CARD: Sedang Dikerjakan --}}
                    <div class="w-1/2 lg:w-1/4 px-2 sm:px-3 mb-4 sm:mb-6 flex">
                        <article class="w-full bg-white p-4 sm:p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col justify-between">
                            <header class="flex justify-between items-start mb-4 sm:mb-0">
                                <div aria-hidden="true" class="p-2 sm:p-3 bg-emerald-50 rounded-2xl text-emerald-500 w-fit">
                                    <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                            </header>
                            <div class="mt-auto">
                                <p class="text-[11px] sm:text-sm font-medium text-slate-500 leading-tight">Dikerjakan</p>
                                <p class="text-2xl sm:text-3xl font-bold text-slate-800 mt-1">{{ $statusInProgress ?? 0 }}</p>
                                <div class="mt-2 w-fit inline-flex items-center text-[9px] sm:text-xs font-medium text-emerald-600 bg-emerald-50 px-2 sm:px-2.5 py-1 rounded-lg">Proses</div>
                            </div>
                        </article>
                    </div>

                    {{-- CARD: WO Selesai --}}
                    <div class="w-1/2 lg:w-1/4 px-2 sm:px-3 mb-4 sm:mb-6 flex">
                        <article class="w-full bg-white p-4 sm:p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col justify-between">
                            <header class="mb-4 sm:mb-0">
                                <div aria-hidden="true" class="p-2 sm:p-3 bg-purple-50 rounded-2xl text-purple-500 w-fit">
                                    <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                    </svg>
                                </div>
                            </header>
                            <div class="mt-auto">
                                <p class="text-[11px] sm:text-sm font-medium text-slate-500">Selesai</p>
                                <p class="text-2xl sm:text-3xl font-bold text-slate-800 mt-1">{{ $woSelesai ?? 0 }}</p>
                                <div class="mt-2 w-fit inline-flex items-center text-[9px] sm:text-xs font-medium text-purple-600 bg-purple-50 px-2 sm:px-2.5 py-1 rounded-lg">Histori WO</div>
                            </div>
                        </article>
                    </div>

                    {{-- CARD: Total Karyawan --}}
                    <div class="w-1/2 lg:w-1/4 px-2 sm:px-3 mb-4 sm:mb-6 flex">
                        <article class="w-full bg-white p-4 sm:p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col justify-between">
                            <header class="mb-4 sm:mb-0">
                                <div aria-hidden="true" class="p-2 sm:p-3 bg-blue-50 rounded-2xl text-blue-500 w-fit">
                                    <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                            </header>
                            <div class="mt-auto">
                                <p class="text-[11px] sm:text-sm font-medium text-slate-500">Karyawan</p>
                                <p class="text-2xl sm:text-3xl font-bold text-slate-800 mt-1">{{ $totalKaryawan ?? 0 }}</p>
                                <div class="mt-2 w-fit inline-flex items-center text-[9px] sm:text-xs font-medium text-blue-600 bg-blue-50 px-2 sm:px-2.5 py-1 rounded-lg">Operasional</div>
                            </div>
                        </article>
                    </div>

                </section>

                {{-- GRAFIK KEUANGAN --}}
                <section aria-label="Grafik Keuangan" class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-slate-100">
                    <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                        <div>
                            <h2 class="text-xl font-bold text-slate-800">Arus Kas Operasional</h2>
                            <p class="text-sm text-slate-500 mt-1">Total Pemasukan 6 Bulan Terakhir</p>
                        </div>
                        <div class="flex gap-4 text-xs font-bold text-slate-500 bg-slate-50 px-4 py-2 rounded-xl border border-slate-100">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-emerald-400 shadow-sm"></span>
                                Pemasukan
                            </div>
                        </div>
                    </header>

                    <!-- PERBAIKAN: Dihilangkan class "h-64" agar tidak mengunci tinggi grafik -->
                    <div id="cashFlowChart" class="mt-4 w-full"></div>
                </section>

                {{-- DAFTAR TUNGGU WORK ORDER --}}
                <section aria-label="Daftar Tunggu Work Order" class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-slate-100 mt-6">
                    <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                        <div>
                            <h2 class="text-xl font-bold text-slate-800">Daftar Tunggu Pekerjaan</h2>
                            <p class="text-sm text-slate-500 mt-1">Work Order yang mengantre untuk segera dikerjakan.</p>
                        </div>
                        <a href="{{ route('work_orders.index', ['status' => 'Pending']) }}" class="px-5 py-2.5 bg-emerald-50 text-emerald-600 font-semibold rounded-xl hover:bg-emerald-100 transition-colors text-sm flex items-center gap-2 shrink-0">
                            Lihat Semua
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </header>

                    <div class="overflow-x-auto rounded-2xl border border-slate-50">
                        <table class="w-full text-left border-collapse min-w-[600px]">
                            <thead>
                                <tr class="bg-slate-50/50 text-slate-500 text-xs uppercase tracking-wider">
                                    <th class="px-6 py-4 font-bold">Nomor WO</th>
                                    <th class="px-6 py-4 font-bold">Pelanggan</th>
                                    <th class="px-6 py-4 font-bold">Jenis Pekerjaan</th>
                                    <th class="px-6 py-4 font-bold text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-slate-50">
                                @forelse($waitingList ?? [] as $wo)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-emerald-600">{{ $wo->wo_number }}</td>
                                    <td class="px-6 py-4 font-semibold text-slate-800">{{ $wo->customer ? $wo->customer->company_name : 'Umum' }}</td>
                                    <td class="px-6 py-4 text-slate-600">{{ Str::limit($wo->job_name, 35) }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-[10px] font-bold uppercase tracking-wide">
                                            {{ $wo->status }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-slate-400 gap-3">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                            </svg>
                                            <p class="font-medium text-sm">Tidak ada antrean pekerjaan saat ini.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

            </div>

            {{-- SIDEBAR --}}
            <aside class="col-span-12 xl:col-span-4 space-y-8 gap-6 xl:sticky xl:top-6">

                {{-- PERINGATAN STOK --}}
                <section aria-label="Peringatan Stok" class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex flex-col h-[420px]">
                    <header class="flex justify-between items-center mb-5 shrink-0">
                        <h2 class="text-base font-semibold text-slate-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Peringatan Stok
                        </h2>
                        <span class="inline-flex items-center gap-1 text-[11px] font-medium text-rose-700 bg-rose-50 border border-rose-200 px-2.5 py-1 rounded-lg">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                            Perlu perhatian
                        </span>
                    </header>

                    <div class="overflow-y-auto flex-1 pr-1 scrollbar-thin scrollbar-thumb-slate-200 scrollbar-track-transparent">
                        <ul role="list" class="flex flex-col gap-2 p-0 m-0">
                            @forelse($lowStockItems ?? [] as $item)

                            @if($item->stock == 0)
                            <li class="flex items-center gap-3 px-3 py-2.5 rounded-xl border border-rose-200 bg-rose-50">
                                <div class="w-9 h-9 rounded-lg bg-rose-100 flex items-center justify-center text-rose-700 text-[11px] font-semibold flex-shrink-0">
                                    {{ strtoupper(substr($item->name, 0, 3)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-[13px] font-medium text-rose-900 truncate">{{ $item->name }}</p>
                                    <span class="inline-flex items-center gap-1 text-[10px] font-medium text-rose-700 bg-rose-100 border border-rose-200 px-1.5 py-0.5 rounded-full mt-0.5">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                        </svg>
                                        Stok habis
                                    </span>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p class="text-[13px] font-semibold text-rose-700">0</p>
                                    <p class="text-[11px] text-rose-400">{{ $item->unit ?? 'Pcs' }}</p>
                                </div>
                            </li>

                            @else
                            <li class="flex items-center gap-3 px-3 py-2.5 rounded-xl border border-slate-100 bg-white hover:border-slate-200 transition-colors">
                                <div class="w-9 h-9 rounded-lg bg-amber-50 flex items-center justify-center text-amber-700 text-[11px] font-semibold flex-shrink-0">
                                    {{ strtoupper(substr($item->name, 0, 3)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-[13px] font-medium text-slate-800 truncate">{{ $item->name }}</p>
                                    <p class="text-[11px] text-slate-400 mt-0.5">Sisa stok</p>
                                    <div class="mt-1 h-[3px] bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full {{ $item->stock <= 3 ? 'bg-rose-400' : 'bg-amber-400' }}"
                                            style="width: {{ min(100, $item->stock * 10) }}%">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p class="text-[13px] font-semibold text-amber-700">{{ $item->stock }}</p>
                                    <p class="text-[11px] text-slate-400">{{ $item->unit ?? 'Pcs' }}</p>
                                </div>
                            </li>
                            @endif

                            @empty
                            <li class="flex flex-col items-center justify-center py-12 gap-3 text-slate-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p class="text-sm">Seluruh stok aman</p>
                            </li>
                            @endforelse
                        </ul>
                    </div>
                </section>

                {{-- AKTIVITAS TERKINI --}}
                <section aria-labelledby="timeline-heading" class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex flex-col h-[420px]">
                    <header class="flex items-center justify-between mb-5 shrink-0">
                        <h3 id="timeline-heading" class="text-base font-semibold text-slate-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Aktivitas Terkini
                        </h3>
                        <span class="text-[11px] font-medium text-slate-500 bg-slate-50 border border-slate-200 px-2.5 py-1 rounded-lg">
                            {{ isset($recentActivities) ? $recentActivities->count() : 0 }} aktivitas
                        </span>
                    </header>

                    <div class="overflow-y-auto flex-1 pr-1 scrollbar-thin scrollbar-thumb-slate-200 scrollbar-track-transparent">
                        <ol class="flex flex-col list-none p-0 m-0" aria-label="Daftar aktivitas terkini">
                            @forelse($recentActivities ?? [] as $activity)
                            <li class="flex gap-3 pb-5 last:pb-0">
                                <div class="flex flex-col items-center flex-shrink-0 w-8">
                                    @if($activity->jumlah_keluar > 0)
                                    <div aria-label="Pemakaian bahan" class="w-8 h-8 rounded-full bg-rose-50 border border-rose-200 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 17L17 7M7 7h10v10" />
                                        </svg>
                                    </div>
                                    @else
                                    <div aria-label="Penambahan stok" class="w-8 h-8 rounded-full bg-blue-50 border border-blue-200 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 7L7 17M17 17H7V7" />
                                        </svg>
                                    </div>
                                    @endif
                                    <div class="w-px flex-1 bg-slate-100 mt-1 last:hidden"></div>
                                </div>

                                <div class="flex-1 pt-1 pb-1">
                                    <div class="flex items-start justify-between gap-2">
                                        <p class="text-[13px] text-slate-500 leading-relaxed flex-1">
                                            <strong class="font-medium text-slate-900">Admin</strong>
                                            @if($activity->jumlah_keluar > 0)
                                            menggunakan <span class="font-medium text-slate-800">{{ $activity->jumlah_keluar }} {{ $activity->sparepart->unit ?? '' }}</span>
                                            <span class="font-medium text-rose-700">{{ $activity->sparepart->name ?? 'Bahan Dihapus' }}</span>
                                            @else
                                            menambahkan <span class="font-medium text-slate-800">{{ $activity->jumlah_masuk }} {{ $activity->sparepart->unit ?? '' }}</span> stok
                                            <span class="font-medium text-blue-700">{{ $activity->sparepart->name ?? 'Bahan Dihapus' }}</span>
                                            @endif
                                        </p>
                                        @if($activity->jumlah_keluar > 0)
                                        <span class="text-[11px] font-medium px-2 py-0.5 rounded-md bg-rose-50 text-rose-700 border border-rose-200 whitespace-nowrap flex-shrink-0">Keluar</span>
                                        @else
                                        <span class="text-[11px] font-medium px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 border border-blue-200 whitespace-nowrap flex-shrink-0">Masuk</span>
                                        @endif
                                    </div>

                                    @if($activity->jumlah_keluar > 0 && $activity->work_order_number)
                                    <div class="inline-flex items-center gap-1 text-[11px] text-slate-500 bg-slate-50 border border-slate-200 px-2 py-0.5 rounded-md mt-1.5">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        {{ $activity->work_order_number }}
                                    </div>
                                    @elseif($activity->jumlah_keluar > 0)
                                    <div class="inline-flex items-center gap-1 text-[11px] text-slate-400 mt-1.5">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                        </svg>
                                        Penyesuaian stok manual
                                    </div>
                                    @endif

                                    <time datetime="{{ $activity->created_at->toIso8601String() }}" class="flex items-center gap-1 text-[11px] text-slate-400 mt-1.5">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $activity->created_at->diffForHumans() }}
                                    </time>
                                </div>
                            </li>
                            @empty
                            <li class="flex flex-col items-center justify-center py-12 gap-3 text-slate-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p class="text-sm">Belum ada aktivitas pencatatan.</p>
                            </li>
                            @endforelse
                        </ol>
                    </div>
                </section>

            </aside>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categories = @json($months);
            const dataPemasukan = @json($pemasukanData);

            var options = {
                series: [{
                    name: 'Pemasukan',
                    data: dataPemasukan
                }],
                chart: {
                    type: 'bar',
                    /* PERBAIKAN: Tinggi diatur secara spesifik dengan angka pasti (bukan persentase) 
                       dan mematikan parentHeightOffset agar tidak menabrak / overflow ke bawah */
                    height: 320,
                    parentHeightOffset: 0,
                    fontFamily: 'Poppins, sans-serif',
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '40%',
                        borderRadius: 4,
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: categories,
                    labels: {
                        style: {
                            colors: '#64748b',
                            fontWeight: 600
                        }
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: '#64748b'
                        },
                        formatter: function(value) {
                            if (value >= 1000000) return 'Rp ' + (value / 1000000).toFixed(1) + ' Jt';
                            else if (value >= 1000) return 'Rp ' + (value / 1000).toFixed(0) + ' Rb';
                            return 'Rp ' + value;
                        }
                    }
                },
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4,
                    yaxis: {
                        lines: {
                            show: true
                        }
                    },
                    /* PERBAIKAN: Menambahkan padding agar tulisan label bulan dan garis grid 
                       di bagian bawah maupun kiri grafik tidak terpotong */
                    padding: {
                        bottom: 0,
                        top: 0,
                        right: 0,
                        left: 10
                    }
                },
                fill: {
                    opacity: 1
                },
                colors: ['#34d399'],
                legend: {
                    show: false
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return "Rp " + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#cashFlowChart"), options);
            chart.render();
        });
    </script>
</x-app-layout>