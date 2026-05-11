<x-app-layout>
    <div x-data="{ isModalOpen: {{ $errors->has('name') ? 'true' : 'false' }}, isModalInboundOpen: false }" class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto font-poppins">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">

            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Inventori Bahan Baku</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola stok sparepart dan bahan baku bengkel.</p>
            </div>

            <div class="flex items-center gap-3">

                <button @click="isModalInboundOpen = true" class="px-4 py-2 bg-slate-900 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-slate-800 focus:ring-4 focus:ring-slate-500/20 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Update Stok
                </button>

                <button @click="isModalOpen = true" type="button" class="px-4 py-2 bg-slate-900 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-slate-800 transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Bahan Baru
                </button>

            </div>

        </div>

        <div class="bg-white rounded-xl border border-slate-300 overflow-hidden shadow-lg">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-200 text-slate-700">
                            <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">KODE & NAMA</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider text-center">SISA STOK</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider text-right">HARGA SATUAN</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($spareparts as $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-slate-800">{{ $item->name }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-md text-xs font-bold {{ $item->stock > 5 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    {{ $item->stock }} {{ $item->unit }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right font-medium text-slate-700">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center items-center gap-1.5" role="group" aria-label="Aksi Bahan Baku">

                                    <div x-data="{ isEditOpen: false }" class="inline-block">

                                        <!-- Tombol Edit -->
                                        <button @click="isEditOpen = true" type="button"
                                            class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                            aria-label="Edit Bahan Baku" title="Edit Bahan Baku">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            <span class="sr-only">Edit Bahan Baku</span>
                                        </button>

                                        {{-- Modal Popup Edit --}}
                                        <div x-show="isEditOpen" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm" role="dialog">
                                            <div @click.away="isEditOpen = false" class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 text-left">
                                                <h2 class="text-xl font-bold text-slate-800 mb-4">Edit Stok Bahan Baku</h2>
                                                <form action="{{ route('spareparts.update', $item->id) }}" method="POST" class="space-y-4">
                                                    @csrf @method('PUT')
                                                    <div>
                                                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Item</label>
                                                        <input type="text" name="name" value="{{ $item->name }}" required class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                                                    </div>
                                                    <div class="flex gap-4">
                                                        <div class="w-1/2">
                                                            <label class="block text-sm font-medium text-slate-700 mb-1">Stok</label>
                                                            <input type="number" name="stock" value="{{ $item->stock }}" required class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                                                        </div>
                                                        <div class="w-1/2">
                                                            <label class="block text-sm font-medium text-slate-700 mb-1">Satuan</label>
                                                            <input type="text" name="unit" value="{{ $item->unit }}" required class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium text-slate-700 mb-1">Harga Satuan (Rp)</label>
                                                        <input type="number" name="price" value="{{ $item->price }}" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                                                    </div>
                                                    <div class="flex justify-end gap-2 mt-6">
                                                        <button type="button" @click="isEditOpen = false" class="px-4 py-2 text-slate-600 hover:bg-slate-100 rounded-lg font-medium transition-colors">Batal</button>
                                                        <button type="submit" class="px-5 py-2 bg-emerald-500 text-white font-medium rounded-lg hover:bg-emerald-600 transition-colors shadow-sm">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <form action="{{ route('spareparts.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus sparepart ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-rose-500"
                                            aria-label="Hapus Bahan Baku" title="Hapus Bahan Baku">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            <span class="sr-only">Hapus Bahan Baku</span>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-14 text-center text-sm text-slate-500">Belum ada data sparepart.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="isModalInboundOpen" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm" role="dialog">
            <div @click.away="isModalInboundOpen = false" class="bg-white rounded-2xl shadow-xl w-full max-w-xl p-6">

                <div class="flex items-center gap-3 mb-4">
                    <h2 class="text-xl font-bold text-slate-800">Update Stok Bahan Baku</h2>
                </div>

                <form action="{{ route('spareparts.update_stock') }}" method="POST" class="space-y-4">
                    @csrf

                    {{-- Input Nama Bahan Baku --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Pilih Bahan Baku <span class="text-red-500">*</span></label>
                        <input list="inbound_list" type="text" name="name" autocomplete="off" placeholder="Ketik nama bahan baku..." required class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                        <datalist id="inbound_list">
                            @foreach($spareparts as $item)
                            <option value="{{ $item->name }}"></option>
                            @endforeach
                        </datalist>
                    </div>

                    {{-- Input Jumlah Masuk & Keluar --}}
                    <div class="flex gap-4">
                        <div class="w-1/2">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Jumlah Masuk</label>
                            <input type="number" name="masuk" min="0" placeholder="Contoh: 50" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                        </div>
                        <div class="w-1/2">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Jumlah Terpakai</label>
                            <input type="number" name="keluar" min="0" placeholder="Contoh: 10" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-rose-500 focus:border-rose-500 outline-none transition-colors">
                        </div>
                    </div>

                    {{-- Input Referensi Work Order --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Digunakan untuk (No. Work Order)</label>

                        <select name="wo" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 outline-none bg-white appearance-none cursor-pointer">
                            <option value="">Pilih WO</option>

                            @foreach($workOrders as $wo)
                            <option value="{{ $wo->wo_number }}">
                                {{ $wo->wo_number }}
                            </option>
                            @endforeach
                        </select>

                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" @click="isModalInboundOpen = false" class="px-4 py-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors font-medium">Batal</button>
                        <button type="submit" class="px-5 py-2 bg-emerald-500 text-white font-medium rounded-lg hover:bg-emerald-600 transition-colors shadow-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="isModalOpen" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm" role="dialog">
            <div @click.away="isModalOpen = false" class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
                <h2 class="text-xl font-bold text-slate-800 mb-4">Tambah Bahan Baku Baru</h2>
                <form action="{{ route('spareparts.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Item <span class="text-red-500">*</span></label>
                        <input list="sparepart_list" type="text" name="name" autocomplete="off" placeholder="Ketik baru atau pilih yang ada..." value="{{ old('name') }}" required class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 outline-none">

                        @error('name')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-4">
                        <div class="w-1/2">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Stok Awal <span class="text-red-500">*</span></label>
                            <input type="number" name="stock" value="0" required class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-emerald-500 outline-none">
                        </div>
                        <div class="w-1/2">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Satuan <span class="text-red-500">*</span></label>
                            <input type="text" name="unit" placeholder="Pcs, Liter..." required class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-emerald-500 outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Harga Satuan (Rp)</label>
                        <input type="number" name="price" value="0" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-emerald-500 outline-none">
                    </div>
                    <div class="flex justify-end gap-2 mt-6">
                        <button type="button" @click="isModalOpen = false" class="px-4 py-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors font-medium">Batal</button>
                        <button type="submit" class="px-5 py-2 bg-emerald-500 text-white font-medium rounded-lg hover:bg-emerald-600 transition-colors shadow-sm">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>