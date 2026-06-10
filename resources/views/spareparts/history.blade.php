<x-app-layout>
    <div class="w-full space-y-6 font-poppins">

        <header class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Arus Pemakaian Bahan</h1>
                <p class="text-sm text-slate-500 mt-1">Riwayat transaksi stok masuk dan penggunaan bahan baku bengkel.</p>
            </div>
        </header>

        <section aria-label="Tabel Riwayat Pergerakan Barang" class="bg-white rounded-xl border border-slate-300 shadow-sm flex flex-col">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-200 text-slate-700 text-xs uppercase tracking-wider">
                        <tr>
                            <th scope="col" class="px-6 py-4 whitespace-nowrap w-48">
                                <div class="flex items-center gap-2">
                                    <div class="relative group">
                                        <div class="flex items-center gap-1.5 cursor-pointer text-slate-600 group-hover:text-slate-900 transition-colors">
                                            <span class="text-xs font-bold uppercase tracking-wider">
                                                {{ request('filter_date') ? \Carbon\Carbon::parse(request('filter_date'))->format('d M Y') : 'TANGGAL & WAKTU' }}
                                            </span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                        <form action="{{ url()->current() }}" method="GET" class="absolute inset-0">
                                            <input type="date" name="filter_date" value="{{ request('filter_date') }}" onchange="this.form.submit()" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" title="Pilih Tanggal Filter">
                                        </form>
                                    </div>
                                    @if(request('filter_date'))
                                    <a href="{{ url()->current() }}" class="inline-flex items-center justify-center bg-rose-100 text-rose-600 rounded-full p-0.5 hover:bg-rose-500 hover:text-white transition-colors" title="Reset">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </a>
                                    @endif
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-xs font-bold">NAMA BAHAN</th>
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-center">MASUK</th>
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-center">JML TERPAKAI</th>
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-center">DIPAKAI PADA</th>
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-center">KETERANGAN</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($histories as $history)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-slate-500 text-sm font-medium">
                                {{ $history->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-900 text-sm">
                                {{ $history->sparepart->name ?? 'Bahan Telah Dihapus' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($history->jumlah_masuk > 0)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-emerald-50 border border-emerald-200 text-emerald-700">+{{ $history->jumlah_masuk }}</span>
                                @else
                                <span class="text-slate-300">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($history->jumlah_keluar > 0)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-rose-50 border border-rose-200 text-rose-700">-{{ $history->jumlah_keluar }}</span>
                                @else
                                <span class="text-slate-300">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($history->work_order_number)
                                <span class="font-mono text-xs px-2.5 py-1 bg-slate-100 border border-slate-200 rounded-md text-slate-600 font-medium">{{ $history->work_order_number }}</span>
                                @else
                                <span class="text-slate-400 italic text-xs">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-600 text-xs">
                                {{ $history->keterangan }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-500">
                                Belum ada riwayat pergerakan barang.
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