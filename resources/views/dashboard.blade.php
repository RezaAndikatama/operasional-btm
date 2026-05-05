<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto font-poppins">

        <!-- HEADER DASHBOARD -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Dashboard Operasional</h1>
                <p class="text-sm text-gray-500 mt-1">Ringkasan aktivitas pencatatan harian PT. Briliant Teknik Mandiri.</p>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-6">

            <!-- KOLOM UTAMA (KIRI) -->
            <div class="col-span-12 xl:col-span-8 space-y-6">

                <!-- SECTION STATISTIK (MENGGUNAKAN FLEXBOX ANTI-MACET) -->
                <section aria-label="Ringkasan Operasional" class="flex flex-wrap -mx-2 sm:-mx-3 mb-4">

                    <!-- Card 1: Work Order Aktif (w-full = Pasti 100% Lebar) -->
                    <div class="w-full px-2 sm:px-3 mb-4 sm:mb-6">
                        <article class="bg-gradient-to-br from-slate-900 to-slate-800 text-white p-6 rounded-3xl shadow-xl shadow-slate-900/20 relative overflow-hidden flex flex-col justify-between min-h-[12rem]">
                            <div class="relative z-10">
                                <p class="text-sm font-medium text-slate-300">Selamat Datang,</p>
                                <h2 class="text-xl md:text-2xl font-semibold mt-1 tracking-wide truncate">{{ Auth::user()->name ?? 'Admin Operasional' }}</h2>
                            </div>
                            <div class="relative z-10 mt-6 md:mt-auto">
                                <p class="text-[10px] uppercase tracking-widest text-emerald-400 font-semibold mb-1">Total WO Aktif</p>
                                <p class="text-4xl md:text-5xl font-bold">{{ $woActive ?? 0 }}</p>
                            </div>
                            <div aria-hidden="true" class="absolute -right-8 -bottom-8 w-32 h-32 bg-emerald-500/20 rounded-full blur-2xl"></div>
                            <div aria-hidden="true" class="absolute right-4 top-4 opacity-20">
                                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                        </article>
                    </div>

                    <!-- Card 2: Status Pending (w-1/2 = Pasti 50% di HP) -->
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

                    <!-- Card 3: Sedang Dikerjakan (w-1/2 = Pasti 50% di HP) -->
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

                    <!-- Card 4: Total Karyawan (w-1/2 = Pasti 50% di HP) -->
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
                                <p class="text-2xl sm:text-3xl font-bold text-slate-800 mt-1">{{ $totalKaryawan }}</p>
                                <div class="mt-2 w-fit inline-flex items-center text-[9px] sm:text-xs font-bold text-blue-600 bg-blue-50 px-2 sm:px-2.5 py-1 rounded-lg">Operasional</div>
                            </div>
                        </article>
                    </div>

                    <!-- Card 5: WO Selesai (w-1/2 = Pasti 50% di HP) -->
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
                                <p class="text-2xl sm:text-3xl font-bold text-slate-800 mt-1">{{ $woSelesai }}</p>
                                <div class="mt-2 w-fit inline-flex items-center text-[9px] sm:text-xs font-bold text-purple-600 bg-purple-50 px-2 sm:px-2.5 py-1 rounded-lg">Histori WO</div>
                            </div>
                        </article>
                    </div>

                </section>

                <!-- SECTION 2: GRAFIK BATANG 6 BULAN -->
                <section aria-label="Grafik Keuangan" class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-slate-100">
                    <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                        <div>
                            <h2 class="text-xl font-bold text-slate-800">Arus Kas Operasional</h2>
                            <p class="text-sm text-slate-500 mt-1">Pemasukan vs Pengeluaran 6 Bulan Terakhir</p>
                        </div>
                        <div class="flex gap-4 text-xs font-bold text-slate-500 bg-slate-50 px-4 py-2 rounded-xl border border-slate-100">
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-emerald-400 shadow-sm"></span> Pemasukan</div>
                            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-rose-400 shadow-sm"></span> Pengeluaran</div>
                        </div>
                    </header>

                    <div class="h-48 flex items-end justify-between gap-2 md:gap-4 mt-4 relative pt-4">
                        <div class="absolute inset-0 flex flex-col justify-between pointer-events-none border-t border-slate-50">
                            <div class="border-b border-dashed border-slate-200 h-full w-full"></div>
                            <div class="border-b border-dashed border-slate-200 h-full w-full"></div>
                            <div class="border-b border-slate-200 h-full w-full"></div>
                        </div>

                        <!-- Bar Nov -->
                        <div class="relative flex justify-center items-end group w-full gap-1 z-10 h-full">
                            <div class="w-full max-w-[2rem] bg-emerald-400 rounded-t-md hover:brightness-110 cursor-pointer" style="height: 60%;"></div>
                            <div class="w-full max-w-[2rem] bg-rose-400 rounded-t-md hover:brightness-110 cursor-pointer" style="height: 40%;"></div>
                            <span class="absolute -bottom-7 text-xs font-semibold text-slate-400">Nov</span>
                        </div>
                        <!-- Bar Des -->
                        <div class="relative flex justify-center items-end group w-full gap-1 z-10 h-full">
                            <div class="w-full max-w-[2rem] bg-emerald-400 rounded-t-md hover:brightness-110 cursor-pointer" style="height: 90%;"></div>
                            <div class="w-full max-w-[2rem] bg-rose-400 rounded-t-md hover:brightness-110 cursor-pointer" style="height: 50%;"></div>
                            <span class="absolute -bottom-7 text-xs font-semibold text-slate-400">Des</span>
                        </div>
                        <!-- Bar Jan -->
                        <div class="relative flex justify-center items-end group w-full gap-1 z-10 h-full">
                            <div class="w-full max-w-[2rem] bg-emerald-400 rounded-t-md hover:brightness-110 cursor-pointer" style="height: 70%;"></div>
                            <div class="w-full max-w-[2rem] bg-rose-400 rounded-t-md hover:brightness-110 cursor-pointer" style="height: 75%;"></div>
                            <span class="absolute -bottom-7 text-xs font-semibold text-slate-400">Jan</span>
                        </div>
                        <!-- Bar Feb -->
                        <div class="relative flex justify-center items-end group w-full gap-1 z-10 h-full">
                            <div class="w-full max-w-[2rem] bg-emerald-400 rounded-t-md hover:brightness-110 cursor-pointer" style="height: 100%;"></div>
                            <div class="w-full max-w-[2rem] bg-rose-400 rounded-t-md hover:brightness-110 cursor-pointer" style="height: 60%;"></div>
                            <span class="absolute -bottom-7 text-xs font-semibold text-slate-400">Feb</span>
                        </div>
                        <!-- Bar Mar -->
                        <div class="relative flex justify-center items-end group w-full gap-1 z-10 h-full">
                            <div class="w-full max-w-[2rem] bg-emerald-400 rounded-t-md hover:brightness-110 cursor-pointer" style="height: 50%;"></div>
                            <div class="w-full max-w-[2rem] bg-rose-400 rounded-t-md hover:brightness-110 cursor-pointer" style="height: 25%;"></div>
                            <span class="absolute -bottom-7 text-xs font-semibold text-slate-400">Mar</span>
                        </div>
                        <!-- Bar Apr -->
                        <div class="relative flex justify-center items-end group w-full gap-1 z-10 h-full">
                            <div class="w-full max-w-[2rem] bg-emerald-400 rounded-t-md hover:brightness-110 cursor-pointer" style="height: 80%;"></div>
                            <div class="w-full max-w-[2rem] bg-rose-400 rounded-t-md hover:brightness-110 cursor-pointer" style="height: 55%;"></div>
                            <span class="absolute -bottom-7 text-xs text-slate-900 font-bold">Apr</span>
                        </div>
                    </div>
                    <div class="h-8"></div>
                </section>

                <!-- Tabel Daftar Tunggu WorkOrder -->
                <section aria-label="Daftar Tunggu Work Order" class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-slate-100 mt-6">
                    <header class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                        <div>
                            <h2 class="text-xl font-bold text-slate-800">Daftar Tunggu Pekerjaan</h2>
                            <p class="text-sm text-slate-500 mt-1">Work Order yang mengantre untuk segera dikerjakan.</p>
                        </div>
                        <!-- Tombol menuju halaman utama pencatatan WO -->
                        <a href="{{ route('work_orders.index') }}" class="px-5 py-2.5 bg-emerald-50 text-emerald-600 font-semibold rounded-xl hover:bg-emerald-100 transition-colors text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                            Lihat Semua
                        </a>
                    </header>

                    <div class="overflow-x-auto rounded-2xl border border-slate-50">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/50 text-slate-500 text-xs uppercase tracking-wider">
                                    <th class="px-6 py-4 font-bold">Nomor WO</th>
                                    <th class="px-6 py-4 font-bold">Pelanggan</th>
                                    <th class="px-6 py-4 font-bold">Jenis Pekerjaan</th>
                                    <th class="px-6 py-4 font-bold">Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-slate-50">
                                @forelse($waitingList ?? [] as $wo)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-slate-800">{{ $wo->wo_number }}</td>
                                    <td class="px-6 py-4 text-slate-600">{{ $wo->customer ? $wo->customer->company_name : 'Umum' }}</td>

                                    <!-- Str::limit digunakan agar teks pekerjaan yang terlalu panjang tidak merusak tabel -->
                                    <td class="px-6 py-4 text-slate-600">{{ Str::limit($wo->job_name, 35) }}</td>

                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-[10px] font-bold uppercase tracking-wide">
                                            {{ $wo->status }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <!-- Tampilan kosong (Empty State) jika tidak ada antrean -->
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-slate-400">
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

            <!-- SIDEBAR KANAN (KOLOM 4) -->
            <aside class="col-span-12 xl:col-span-4 space-y-6">

                <!-- SECTION 3: ALERT STOK MENIPIS (DATA RIIL) -->
                <section aria-label="Peringatan Stok" class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-slate-100">
                    <header class="mb-6 flex justify-between items-center">
                        <h2 class="text-lg font-bold text-slate-800">Stok Rendah</h2>
                        <span class="bg-red-50 text-red-500 text-xs font-bold px-2 py-1 rounded-lg">Peringatan</span>
                    </header>

                    <ul role="list" class="space-y-4">
                        @forelse($lowStockItems as $item)
                        <li class="flex justify-between items-center p-4 bg-slate-50 rounded-2xl border border-slate-100 hover:border-slate-200 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-rose-100 flex items-center justify-center text-rose-500 font-bold text-xs uppercase">{{ substr($item->name, 0, 3) }}</div>
                                <div>
                                    <p class="font-semibold text-slate-800 text-sm">{{ $item->name }}</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Sisa Stok</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-red-500 font-bold text-sm">{{ $item->stock }} {{ $item->unit ?? 'Pcs' }}</p>
                            </div>
                        </li>
                        @empty
                        <li class="text-center py-4">
                            <p class="text-sm text-slate-500 font-medium">Seluruh stok aman (> 10 Unit)</p>
                        </li>
                        @endforelse
                    </ul>
                </section>

                <!-- SECTION 4: LOG AKTIVITAS (DUMMY) -->
                <section aria-label="Log Operasional" class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-slate-100">
                    <header class="mb-6">
                        <h2 class="text-lg font-bold text-slate-800">Aktivitas Terkini</h2>
                    </header>

                    <div class="relative pl-4">
                        <div aria-hidden="true" class="absolute left-6 top-2 bottom-0 w-0.5 bg-slate-100"></div>

                        <ul role="list" class="space-y-6 relative">
                            <li class="relative flex gap-4 items-start">
                                <div class="z-10 flex-shrink-0 w-5 h-5 rounded-full bg-emerald-500 ring-4 ring-white mt-0.5"></div>
                                <div>
                                    <p class="text-sm text-slate-700 leading-snug"><span class="font-bold text-slate-900">Teknisi Budi</span> menyelesaikan WO-2604-001.</p>
                                    <p class="text-xs text-slate-400 mt-1 font-medium">10 Menit yang lalu</p>
                                </div>
                            </li>
                            <li class="relative flex gap-4 items-start">
                                <div class="z-10 flex-shrink-0 w-5 h-5 rounded-full bg-blue-500 ring-4 ring-white mt-0.5"></div>
                                <div>
                                    <p class="text-sm text-slate-700 leading-snug"><span class="font-bold text-slate-900">Admin</span> melakukan pencatatan stok Oli Mesin.</p>
                                    <p class="text-xs text-slate-400 mt-1 font-medium">1 Jam yang lalu</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </section>

            </aside>
        </div>
    </div>
</x-app-layout>