<x-app-layout>
    {{-- Inisiasi Alpine.js state untuk Modal Create --}}
    <div x-data="{ isModalOpen: false }" class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto font-poppins">

        {{-- 1. HEADER & TOMBOL TRIGGER MODAL --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Daftar Work Order</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola daftar pengerjaan klien PT. Briliant Teknik Mandiri.</p>
            </div>

            <button @click="isModalOpen = true" type="button" class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Work Order
            </button>
        </div>

        {{-- 2. TABEL DAFTAR WORK ORDER --}}
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead style="background-color: #eef2f6;">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">NAMA PERUSAHAAN</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">PEKERJAAN</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider text-center">STATUS</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider text-right">TOTAL BIAYA</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($workOrders as $wo)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-xs font-bold text-emerald-600 mb-0.5">{{ $wo->wo_number }}</div>
                                <div class="text-sm font-semibold text-slate-800">{{ $wo->customer->company_name }}</div>
                                <div class="text-xs text-slate-500 mt-0.5">PIC: {{ $wo->customer->pic_name }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">
                                <div class="font-medium text-slate-800">{{ $wo->job_name }}</div>
                                @if($wo->description)
                                <div class="text-xs text-slate-500 mt-1 truncate max-w-[200px]">{{ $wo->description }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                $statusColor = match($wo->status) {
                                'Selesai' => 'bg-emerald-100 text-emerald-700',
                                'Sedang Dikerjakan' => 'bg-amber-100 text-amber-700',
                                default => 'bg-slate-100 text-slate-600',
                                };
                                @endphp
                                <span class="px-3 py-1 rounded-md text-[11px] font-bold uppercase {{ $statusColor }}">
                                    {{ $wo->status }}
                                </span>
                            </td>

                            {{-- Kolom 4: TOTAL BIAYA & STATUS PEMBAYARAN --}}
                            <td class="px-6 py-4 text-right">
                                <div class="text-sm font-bold text-slate-700">Rp {{ number_format($wo->total_cost, 0, ',', '.') }}</div>
                                <div class="text-[11px] text-slate-500 mt-0.5 mb-2">Dibayar: Rp {{ number_format($wo->paid_amount, 0, ',', '.') }}</div>

                                {{-- Smart Logic: Cek Status Pembayaran --}}
                                @if($wo->total_cost > 0 && $wo->paid_amount >= $wo->total_cost)
                                <span class="inline-block px-2 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-extrabold uppercase tracking-wider rounded border border-emerald-200">
                                    Lunas
                                </span>
                                @elseif($wo->paid_amount > 0 && $wo->paid_amount < $wo->total_cost)
                                    <span class="inline-block px-2 py-1 bg-amber-100 text-amber-700 text-[10px] font-extrabold uppercase tracking-wider rounded border border-amber-200">
                                        Belum Lunas
                                    </span>
                                    @else
                                    <span class="inline-block px-2 py-1 bg-rose-100 text-rose-700 text-[10px] font-extrabold uppercase tracking-wider rounded border border-rose-200">
                                        Belum Bayar
                                    </span>
                                    @endif
                            </td>

                            <td class="px-6 py-4">
                                {{-- Kolom Aksi (Teks) --}}
                                <div class="flex justify-center items-center gap-4">

                                    {{-- Tombol Cetak Invoice --}}
                                    <a href="{{ route('work_orders.invoice', $wo->id) }}" target="_blank" class="text-sm font-semibold text-blue-600 hover:text-blue-800 hover:underline transition-all">
                                        Cetak
                                    </a>

                                    {{-- ========================================== --}}
                                    {{-- TOMBOL EDIT & MODAL EDIT --}}
                                    {{-- ========================================== --}}
                                    <div x-data="{ isEditOpen: false }" class="inline">
                                        {{-- Tombol Trigger Edit --}}
                                        <button @click="isEditOpen = true" type="button" class="text-sm font-semibold text-emerald-600 hover:text-emerald-800 hover:underline transition-all">
                                            Edit
                                        </button>

                                        {{-- Modal Edit Popup --}}
                                        <div x-show="isEditOpen" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden p-4 sm:p-6 lg:p-8 text-left" role="dialog">
                                            <div x-show="isEditOpen" x-transition.opacity @click="isEditOpen = false" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm"></div>

                                            <main x-show="isEditOpen" x-transition class="relative bg-white rounded-2xl shadow-xl w-full max-w-5xl mx-auto overflow-hidden font-poppins flex flex-col max-h-[90vh] z-50">
                                                <header class="flex items-center justify-between px-8 py-6 border-b border-slate-100 bg-white sticky top-0">
                                                    <div>
                                                        <h2 class="text-xl font-bold text-slate-800">Edit Work Order: {{ $wo->wo_number }}</h2>
                                                    </div>
                                                    <button type="button" @click="isEditOpen = false" class="text-slate-400 hover:text-slate-600 p-2">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </header>

                                                <div class="overflow-y-auto p-8">
                                                    <form id="editForm{{ $wo->id }}" action="{{ route('work_orders.update', $wo->id) }}" method="POST" class="space-y-8">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="flex flex-col md:flex-row w-full">
                                                            <fieldset class="w-full md:w-1/2 md:pr-8 space-y-7">
                                                                <legend class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-4">Data Utama Pekerjaan</legend>
                                                                <div>
                                                                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Perusahaan / Pelanggan <span class="text-red-500">*</span></label>
                                                                    <input type="text" name="customer_name" list="customer_list" value="{{ $wo->customer->company_name }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 outline-none transition-all autocomplete-off">
                                                                </div>
                                                                <div>
                                                                    <label class="block text-sm font-medium text-slate-700 mb-2">Judul Pekerjaan / Project <span class="text-red-500">*</span></label>
                                                                    <input type="text" name="job_name" value="{{ $wo->job_name }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 outline-none transition-all">
                                                                </div>
                                                                <div>
                                                                    <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi Kerusakan / Instruksi</label>
                                                                    <textarea name="description" rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 outline-none transition-all">{{ $wo->description }}</textarea>
                                                                </div>
                                                            </fieldset>

                                                            <fieldset class="w-full md:w-1/2 md:pl-8 space-y-7 mt-8 md:mt-0 md:border-l border-slate-200">
                                                                <legend class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-4">Administrasi & Biaya</legend>
                                                                <div>
                                                                    <label class="block text-sm font-medium text-slate-700 mb-2">Status Pekerjaan</label>
                                                                    <select name="status" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 outline-none transition-all">
                                                                        <option value="Pending" {{ $wo->status == 'Pending' ? 'selected' : '' }}>Pending (Menunggu Antrean)</option>
                                                                        <option value="Sedang Dikerjakan" {{ $wo->status == 'Sedang Dikerjakan' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                                                                        <option value="Selesai" {{ $wo->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                                                    </select>
                                                                </div>
                                                                <div>
                                                                    <label class="block text-sm font-medium text-slate-700 mb-2">Total Biaya (Invoice) <span class="text-red-500">*</span></label>
                                                                    <div class="flex">
                                                                        <span class="inline-flex items-center px-4 rounded-l-xl border border-r-0 border-slate-200 bg-slate-100 text-slate-500 text-sm font-semibold">Rp</span>
                                                                        <input type="number" name="total_cost" value="{{ (int)$wo->total_cost }}" required class="flex-1 w-full px-4 py-3 rounded-r-xl border border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 outline-none transition-all">
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <label class="block text-sm font-medium text-slate-700 mb-2">Sudah Dibayar / DP <span class="text-red-500">*</span></label>
                                                                    <div class="flex">
                                                                        <span class="inline-flex items-center px-4 rounded-l-xl border border-r-0 border-slate-200 bg-slate-100 text-slate-500 text-sm font-semibold">Rp</span>
                                                                        <input type="number" name="paid_amount" value="{{ (int)$wo->paid_amount }}" required class="flex-1 w-full px-4 py-3 rounded-r-xl border border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 outline-none transition-all">
                                                                    </div>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </form>
                                                </div>

                                                <footer class="flex items-center justify-end gap-3 px-8 py-8 border-t border-slate-100 bg-slate-50 sticky bottom-0">
                                                    <button type="button" @click="isEditOpen = false" class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800 transition-colors">Batal</button>
                                                    <button form="editForm{{ $wo->id }}" type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-8 py-2.5 rounded-xl text-sm font-bold transition-all shadow-md shadow-emerald-100">Update Data</button>
                                                </footer>
                                            </main>
                                        </div>
                                    </div>

                                    {{-- Form Hapus dengan Konfirmasi --}}
                                    <form action="{{ route('work_orders.destroy', $wo->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data Work Order ini? Semua data relasi (termasuk penggunaan sparepart) akan ikut terhapus.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm font-semibold text-red-600 hover:text-red-800 hover:underline transition-all">
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-14 text-center text-sm text-slate-500">
                                Belum ada data work order yang terdaftar.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- 3. MODAL (POPUP) FORM WORK ORDER BARU --}}
        <div x-show="isModalOpen"
            style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden p-4 sm:p-6 lg:p-8"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">

            {{-- Background Overlay Blur --}}
            <div x-show="isModalOpen"
                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                @click="isModalOpen = false"
                class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"></div>

            {{-- Modal Content Card --}}
            <main x-show="isModalOpen"
                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative bg-white rounded-2xl shadow-xl w-full max-w-5xl mx-auto overflow-hidden font-poppins flex flex-col max-h-[90vh] z-50">

                {{-- Modal Header --}}
                <header class="flex items-center justify-between px-8 py-6 border-b border-slate-100 bg-white sticky top-0">
                    <div>
                        <h2 id="modal-headline" class="text-xl font-bold text-slate-800">Buat Work Order Baru</h2>
                        <p class="text-xs text-slate-500 mt-1">Gunakan formulir ini untuk mendaftarkan pengerjaan teknis baru dari pelanggan.</p>
                    </div>
                    <button type="button" @click="isModalOpen = false" class="text-slate-400 hover:text-slate-600 p-2 rounded-lg hover:bg-slate-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </header>

                {{-- Modal Form Body --}}
                <div class="overflow-y-auto p-8">
                    <form id="workOrderForm" action="{{ route('work_orders.store') }}" method="POST" class="space-y-8">
                        @csrf

                        <div class="flex flex-col md:flex-row w-full">

                            {{-- Fieldset Kiri: Data Utama --}}
                            <fieldset class="w-full md:w-1/2 md:pr-8 space-y-7">
                                <legend class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-4">Data Utama Pekerjaan</legend>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Perusahaan / Pelanggan <span class="text-red-500">*</span></label>

                                    <input type="text" name="customer_name" list="customer_list" placeholder="Ketik nama pelanggan baru atau pilih..." required
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 outline-none transition-all autocomplete-off">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Judul Pekerjaan / Project <span class="text-red-500">*</span></label>
                                    <input type="text" name="job_name" placeholder="Contoh: Perbaikan Panel Listrik Ruang A" required
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 outline-none transition-all">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi Kerusakan / Instruksi</label>
                                    <textarea name="description" rows="4" placeholder="Jelaskan detail pengerjaan..."
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 outline-none transition-all"></textarea>
                                </div>
                            </fieldset>

                            {{-- Fieldset Kanan: Administrasi --}}
                            <fieldset class="w-full md:w-1/2 md:pl-8 space-y-7 mt-8 md:mt-0 md:border-l border-slate-200">
                                <legend class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-4">Administrasi & Biaya</legend>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Status Pekerjaan</label>
                                    <select name="status" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 outline-none transition-all">
                                        <option value="Pending">Pending (Menunggu Antrean)</option>
                                        <option value="Sedang Dikerjakan">Sedang Dikerjakan</option>
                                        <option value="Selesai">Selesai</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Total Biaya (Invoice) <span class="text-red-500">*</span></label>
                                    <div class="flex">
                                        <span class="inline-flex items-center px-4 rounded-l-xl border border-r-0 border-slate-200 bg-slate-100 text-slate-500 text-sm font-semibold">Rp</span>
                                        <input type="number" name="total_cost" placeholder="0" required
                                            class="flex-1 w-full px-4 py-3 rounded-r-xl border border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 outline-none transition-all">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Sudah Dibayar / DP <span class="text-red-500">*</span></label>
                                    <div class="flex">
                                        <span class="inline-flex items-center px-4 rounded-l-xl border border-r-0 border-slate-200 bg-slate-100 text-slate-500 text-sm font-semibold">Rp</span>
                                        <input type="number" name="paid_amount" placeholder="0" required
                                            class="flex-1 w-full px-4 py-3 rounded-r-xl border border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 outline-none transition-all">
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </form>
                </div>

                {{-- Modal Footer --}}
                <footer class="flex items-center justify-end gap-3 px-8 py-8 border-t border-slate-100 bg-slate-50 sticky bottom-0">
                    <button type="button" @click="isModalOpen = false" class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800 transition-colors">
                        Batal
                    </button>
                    <button form="workOrderForm" type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-8 py-2.5 rounded-xl text-sm font-bold transition-all shadow-md shadow-emerald-100">
                        Simpan
                    </button>
                </footer>
            </main>
        </div>

        {{-- Datalist untuk semua input autocomplete pelanggan (Disimpan di luar tabel agar tidak duplikat) --}}
        <datalist id="customer_list">
            @foreach($customers as $customer)
            <option value="{{ $customer->company_name }}"></option>
            @endforeach
        </datalist>

    </div>
</x-app-layout>