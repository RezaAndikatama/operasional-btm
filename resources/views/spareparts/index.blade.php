<x-app-layout>
    <div x-data="{ isModalOpen: {{ $errors->has('name') ? 'true' : 'false' }}, isModalInboundOpen: false }" class="w-full space-y-6 font-poppins">

        <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Inventori Bahan Baku</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola stok sparepart dan bahan baku bengkel.</p>
            </div>

            <div class="flex items-center gap-3">
                <button @click="isModalInboundOpen = true" class="px-4 py-2 bg-slate-900 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-slate-800 focus:ring-4 focus:ring-slate-500/20 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Update Stok
                </button>

                <button @click="isModalOpen = true" type="button" class="px-4 py-2 bg-slate-900 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-slate-800 transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Bahan Baru
                </button>
            </div>
        </header>

        <section aria-label="Data Tabel Inventori" class="bg-white rounded-xl border border-slate-300 shadow-sm flex flex-col">
            <div class="overflow-auto max-h-[calc(100vh-200px)]">
                <table class="w-full text-left border-collapse relative">
                    <thead class="bg-slate-200 text-slate-700">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-slate-600 uppercase tracking-wider bg-slate-200">KODE & NAMA</th>
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-slate-600 uppercase tracking-wider text-center bg-slate-200">SISA STOK</th>
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-slate-600 uppercase tracking-wider text-right bg-slate-200">HARGA SATUAN</th>
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-slate-600 uppercase tracking-wider text-center bg-slate-200">AKSI</th>
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

                                        <button @click="isEditOpen = true" type="button"
                                            class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                            aria-label="Edit Bahan Baku" title="Edit Bahan Baku">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            <span class="sr-only">Edit Bahan Baku</span>
                                        </button>

                                        <div x-show="isEditOpen"
                                            style="display: none;"
                                            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden p-4 sm:p-6 lg:p-8 text-left"
                                            role="dialog" aria-modal="true">

                                            <div x-show="isEditOpen"
                                                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                                @click="isEditOpen = false"
                                                class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"></div>

                                            <div x-show="isEditOpen"
                                                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                class="relative bg-white rounded-2xl shadow-xl w-full max-w-md mx-auto overflow-hidden font-poppins flex flex-col z-50">

                                                <header class="flex items-center justify-between px-6 py-5 border-b border-slate-100 bg-white">
                                                    <h2 class="text-xl font-bold text-slate-800">Edit Stok Bahan Baku</h2>
                                                    <button type="button" @click="isEditOpen = false" class="text-slate-400 hover:text-slate-600 p-2 rounded-lg hover:bg-slate-50 shrink-0">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </header>

                                                <div class="p-6">
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
                                                        <div class="mt-8 flex justify-end gap-3 border-t border-slate-100 pt-5">
                                                            <button type="button" @click="isEditOpen = false" class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-xl transition-colors">Batal</button>
                                                            <button type="submit" class="px-5 py-2.5 bg-emerald-500 text-white font-medium rounded-xl hover:bg-emerald-600 transition-colors shadow-sm">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <form action="{{ route('spareparts.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus sparepart ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-rose-500"
                                            aria-label="Hapus Bahan Baku" title="Hapus Bahan Baku">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
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
        </section>

        <div x-show="isModalInboundOpen"
            style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden p-4 sm:p-6 lg:p-8"
            role="dialog" aria-modal="true">

            <div x-show="isModalInboundOpen"
                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                @click="isModalInboundOpen = false"
                class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"></div>

            <div x-show="isModalInboundOpen"
                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative bg-white rounded-2xl shadow-xl w-full max-w-xl mx-auto overflow-hidden font-poppins flex flex-col z-50">

                <header class="flex items-center justify-between px-6 py-5 border-b border-slate-100 bg-white">
                    <h2 class="text-xl font-bold text-slate-800">Update Stok Bahan Baku</h2>
                    <button type="button" @click="isModalInboundOpen = false" class="text-slate-400 hover:text-slate-600 p-2 rounded-lg hover:bg-slate-50 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </header>

                <div class="p-6">
                    <form action="{{ route('spareparts.update_stock') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Pilih Bahan Baku <span class="text-red-500">*</span></label>
                            <input list="inbound_list" type="text" name="name" autocomplete="off" placeholder="Ketik nama bahan baku..." required class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                            <datalist id="inbound_list">
                                @foreach($spareparts as $item)
                                <option value="{{ $item->name }}"></option>
                                @endforeach
                            </datalist>
                        </div>
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
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Digunakan untuk (No. Work Order)</label>
                            <select name="wo" class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 outline-none bg-white appearance-none cursor-pointer">
                                <option value="">Pilih WO</option>
                                @foreach($workOrders as $wo)
                                <option value="{{ $wo->wo_number }}">{{ $wo->wo_number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-8 flex justify-end gap-3 border-t border-slate-100 pt-5">
                            <button type="button" @click="isModalInboundOpen = false" class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-xl transition-colors">Batal</button>
                            <button type="submit" class="px-5 py-2.5 bg-emerald-500 text-white font-medium rounded-xl hover:bg-emerald-600 transition-colors shadow-sm">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div x-show="isModalOpen"
            style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden p-4 sm:p-6 lg:p-8"
            role="dialog" aria-modal="true">

            <div x-show="isModalOpen"
                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                @click="isModalOpen = false"
                class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"></div>

            <div x-show="isModalOpen"
                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative bg-white rounded-2xl shadow-xl w-full max-w-md mx-auto overflow-hidden font-poppins flex flex-col z-50">

                <header class="flex items-center justify-between px-6 py-5 border-b border-slate-100 bg-white">
                    <h2 class="text-xl font-bold text-slate-800">Tambah Bahan Baku Baru</h2>
                    <button type="button" @click="isModalOpen = false" class="text-slate-400 hover:text-slate-600 p-2 rounded-lg hover:bg-slate-50 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </header>

                <div class="p-6">
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
                        <div class="mt-8 flex justify-end gap-3 border-t border-slate-100 pt-5">
                            <button type="button" @click="isModalOpen = false" class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-xl transition-colors">Batal</button>
                            <button type="submit" class="px-5 py-2.5 bg-emerald-500 text-white font-medium rounded-xl hover:bg-emerald-600 transition-colors shadow-sm">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>