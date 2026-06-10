<x-app-layout>
    <main class="space-y-6">

        <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Rekapitulasi Transaksi</h1>
                <p class="text-sm text-slate-500 mt-1">Data riwayat pengerjaan bengkel yang telah selesai dikerjakan.</p>
            </div>

            <form method="GET" action="{{ route('rekapitulasi.index') }}" class="w-full sm:w-auto flex items-center gap-3">
                <label for="bulan" class="text-sm font-semibold text-slate-600 hidden sm:block">Pilih Bulan:</label>
                <input type="month" id="bulan" name="bulan" value="{{ $filterBulan }}" onchange="this.form.submit()"
                    class="w-full sm:w-auto bg-white border border-slate-200 text-slate-700 px-4 py-2.5 rounded-xl text-sm font-bold focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm outline-none cursor-pointer transition-all hover:border-emerald-400">
            </form>
        </header>

        <section aria-label="Ringkasan Metrik" class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <article class="relative bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition-shadow duration-300 w-full overflow-hidden group">
                <div class="absolute top-0 right-0 -mt-6 -mr-6 w-32 h-32 bg-emerald-100 rounded-full opacity-50 blur-2xl group-hover:bg-emerald-200 transition-colors duration-500" aria-hidden="true"></div>

                <div class="relative z-10">
                    <header class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-[13px] font-bold text-slate-500 uppercase tracking-widest">Pendapatan</h3>
                            <div class="inline-flex items-center gap-1.5 mt-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500" aria-hidden="true"></span>
                                <p class="text-xs font-medium text-slate-400">Periode <span class="text-slate-600">{{ $namaBulan }}</span></p>
                            </div>
                        </div>

                        <div class="flex-shrink-0 p-2.5 bg-emerald-50/80 border border-emerald-100 text-emerald-600 rounded-xl shadow-sm" aria-hidden="true">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </header>

                    <div class="flex flex-col">
                        <h2 class="text-3xl font-bold text-slate-800 tracking-tight">
                            Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                        </h2>
                        <div class="w-12 h-1 bg-emerald-500 rounded-full mt-5" aria-hidden="true"></div>
                    </div>
                </div>
            </article>

            <article class="relative bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition-shadow duration-300 w-full overflow-hidden group">
                <div class="absolute top-0 right-0 -mt-6 -mr-6 w-32 h-32 bg-blue-100 rounded-full opacity-50 blur-2xl group-hover:bg-blue-200 transition-colors duration-500" aria-hidden="true"></div>

                <div class="relative z-10">
                    <header class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-[13px] font-bold text-slate-500 uppercase tracking-widest">Total Order Selesai</h3>
                            <div class="inline-flex items-center gap-1.5 mt-1.5">
                                <span class="w-2 h-2 rounded-full bg-blue-500" aria-hidden="true"></span>
                                <p class="text-xs font-medium text-slate-400">Periode <span class="text-slate-600">{{ $namaBulan }}</span></p>
                            </div>
                        </div>

                        <div class="flex-shrink-0 p-2.5 bg-blue-50/80 border border-blue-100 text-blue-600 rounded-xl shadow-sm" aria-hidden="true">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                    </header>

                    <div class="flex flex-col">
                        <h2 class="text-3xl font-bold text-slate-800 tracking-tight flex items-baseline gap-2">
                            {{ $transaksi->total() }} <span class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Work Order</span>
                        </h2>
                        <div class="w-12 h-1 bg-blue-500 rounded-full mt-5" aria-hidden="true"></div>
                    </div>
                </div>
            </article>

        </section>

        <section aria-label="Tabel Data Riwayat Transaksi" class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-200 border-b border-slate-200">
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">No. WO</th>
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Pekerjaan</th>
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Keterangan</th>
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Selesai Pada</th>
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Total Biaya</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse($transaksi as $item)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-md border border-emerald-100">
                                    {{ $item->wo_number }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-800">
                                {{ $item->job_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500" aria-hidden="true"></span>
                                    Selesai
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($item->paid_amount >= $item->total_cost)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500" aria-hidden="true"></span>
                                    Lunas
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500" aria-hidden="true"></span>
                                    Belum Lunas
                                </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-slate-500 whitespace-nowrap">
                                <time datetime="{{ $item->updated_at->toIso8601String() }}">
                                    {{ $item->updated_at->translatedFormat('d M Y') }} <span class="text-slate-400 text-xs ml-1">{{ $item->updated_at->format('H:i') }}</span>
                                </time>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <span class="font-bold text-slate-800">
                                    Rp {{ number_format($item->total_cost, 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <svg class="w-8 h-8 mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="font-medium text-slate-500">Belum ada transaksi selesai</p>
                                    <p class="text-xs mt-1">Data untuk bulan <strong class="text-slate-600">{{ $namaBulan }}</strong> masih kosong.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($transaksi->hasPages())
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
                {{ $transaksi->links() }}
            </div>
            @endif

        </section>

    </main>
</x-app-layout>