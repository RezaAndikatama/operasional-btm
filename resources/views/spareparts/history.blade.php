<x-app-layout>
    <div class="w-full space-y-6 font-poppins">

        <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Arus Pemakaian Bahan</h1>
                <p class="text-sm text-slate-500 mt-1">Riwayat transaksi stok masuk dan penggunaan bahan baku bengkel.</p>
            </div>

            {{-- FILTER SORTIR PER BULAN --}}
            <form method="GET" action="{{ route('spareparts.history') }}" class="flex items-center gap-3 bg-white p-2 rounded-xl border border-slate-200 shadow-sm w-fit">
                <label for="month" class="text-sm font-semibold text-slate-600 pl-2">Filter Bulan:</label>
                <div class="flex items-center gap-2">
                    <input type="month" name="month" id="month"
                        value="{{ request('month', now()->format('Y-m')) }}"
                        onchange="this.form.submit()"
                        class="px-3 py-1.5 border-none bg-slate-50 text-slate-700 rounded-lg text-sm focus:ring-0 cursor-pointer font-medium"
                        title="Pilih Bulan">

                    {{-- Tombol reset muncul jika bulan yang dipilih bukan bulan ini --}}
                    @if(request('month') && request('month') != now()->format('Y-m'))
                    <a href="{{ route('spareparts.history') }}"
                        class="p-1.5 text-rose-500 hover:bg-rose-50 rounded-md transition-colors" title="Reset ke Bulan Ini">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </a>
                    @endif
                </div>
            </form>
        </header>

        <section aria-label="Tabel Riwayat Pergerakan Barang" class="bg-white rounded-xl border border-slate-300 shadow-sm flex flex-col">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-200 text-slate-700 text-xs uppercase tracking-wider">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-bold">TANGGAL & WAKTU</th>
                            <th scope="col" class="px-6 py-4 font-bold">NAMA BAHAN</th>
                            <th scope="col" class="px-6 py-4 font-bold text-center">MASUK</th>
                            <th scope="col" class="px-6 py-4 font-bold text-center">TERPAKAI</th>
                            <th scope="col" class="px-6 py-4 font-bold text-center">DIPAKAI PADA</th>
                            <th scope="col" class="px-6 py-4 font-bold">KETERANGAN HARGA</th>
                            <th scope="col" class="px-6 py-4 font-bold">DIUPDATE OLEH</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($histories as $history)
                        <tr class="hover:bg-slate-50 transition-colors">

                            {{-- TANGGAL DENGAN FORMAT HARI & JAM --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-slate-800">{{ $history->created_at->translatedFormat('d M Y') }}</div>
                                <div class="text-[11px] text-slate-400 font-medium">{{ $history->created_at->format('H:i') }} WIB</div>
                            </td>

                            <td class="px-6 py-4 font-semibold text-slate-900 text-sm">
                                {{ $history->sparepart->name ?? 'Bahan Telah Dihapus' }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if($history->jumlah_masuk > 0)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-emerald-50 border border-emerald-200 text-emerald-700">
                                    +{{ $history->jumlah_masuk }} {{ $history->sparepart->unit ?? '' }}
                                </span>
                                @else
                                <span class="text-slate-400 text-[11px] italic font-medium">-</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if($history->jumlah_keluar > 0)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-rose-50 border border-rose-200 text-rose-700">
                                    -{{ $history->jumlah_keluar }} {{ $history->sparepart->unit ?? '' }}
                                </span>
                                @else
                                <span class="text-slate-400 text-[11px] italic font-medium">-</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if($history->work_order_number)
                                <span class="font-mono text-xs px-2.5 py-1 bg-slate-100 border border-slate-200 rounded-md text-slate-600 font-medium">
                                    {{ $history->work_order_number }}
                                </span>
                                @else
                                <span class="text-slate-400 text-[11px] italic font-medium">Internal / Manual</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-slate-600 text-xs">Harga Satuan
                                Rp {{ number_format($history->sparepart->price ?? 0, 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-xs font-semibold text-slate-800 bg-slate-100 px-2.5 py-1.5 rounded-lg border border-slate-200">
                                    {{ $history->user->name ?? 'Sistem' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-sm text-slate-500">
                                Belum ada riwayat pergerakan barang pada bulan ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($histories, 'hasPages') && $histories->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                {{ $histories->links() }}
            </div>
            @endif
        </section>
    </div>
</x-app-layout>