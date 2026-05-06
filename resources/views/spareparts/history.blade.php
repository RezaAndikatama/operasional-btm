<x-app-layout>
    <div class="p-6">
        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Arus Pemakaian Bahan</h1>
            <p class="text-sm text-slate-500 mt-1">Riwayat transaksi stok masuk dan penggunaan bahan baku bengkel.</p>
        </div>

        {{-- Tabel Riwayat --}}
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-200 border-b border-slate-200 text-slate-800 font-semibold">
                        <tr>
                            <th class="px-6 py-4 whitespace-nowrap">TANGGAL & WAKTU</th>
                            <th class="px-6 py-4">NAMA BAHAN</th>
                            <th class="px-6 py-4 text-center">MASUK</th>
                            <th class="px-6 py-4 text-center">JML TERPAKAI</th>
                            <th class="px-6 py-4">DIPAKAI PADA</th>
                            <th class="px-6 py-4">KETERANGAN</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 text-slate-700">
                        @forelse($histories as $history)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $history->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-900">
                                {{ $history->sparepart->name ?? 'Bahan Telah Dihapus' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($history->jumlah_masuk > 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                    +{{ $history->jumlah_masuk }}
                                </span>
                                @else
                                <span class="text-slate-300">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($history->jumlah_keluar > 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800">
                                    -{{ $history->jumlah_keluar }}
                                </span>
                                @else
                                <span class="text-slate-300">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($history->work_order_number)
                                <span class="font-mono text-xs px-2 py-1 bg-slate-100 border border-slate-200 rounded text-slate-600">{{ $history->work_order_number }}</span>
                                @else
                                <span class="text-slate-400 italic text-xs">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500 text-xs">
                                {{ $history->keterangan }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                Belum ada riwayat pergerakan barang.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($histories->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                {{ $histories->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>