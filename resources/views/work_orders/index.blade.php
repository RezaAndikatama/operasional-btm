<x-app-layout>
    <main x-data="{ isModalOpen: false }" class="w-full space-y-6 font-poppins">

        <header class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">

            <div class="flex-1 min-w-0">
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight truncate">Daftar Work Order</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola daftar pengerjaan klien PT. Briliant Teknik Mandiri.</p>
            </div>

            <div class="flex flex-wrap items-center justify-end gap-3 flex-shrink-0 w-full lg:w-auto">

                <form method="GET" action="{{ url()->current() }}" class="flex flex-wrap items-center gap-3 m-0 w-full lg:w-auto">
                    <select name="status" onchange="this.form.submit()"
                        class="flex-1 sm:flex-none w-full sm:w-auto bg-white border border-slate-200 text-slate-700 px-4 py-2.5 rounded-lg text-sm font-medium focus:ring-emerald-500 focus:border-emerald-500 shadow-sm outline-none cursor-pointer transition-colors hover:bg-slate-50">
                        <option value="">Semua Status</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Sedang Dikerjakan" {{ request('status') == 'Sedang Dikerjakan' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                    </select>

                    <select name="sort" onchange="this.form.submit()"
                        class="flex-1 sm:flex-none w-full sm:w-auto bg-white border border-slate-200 text-slate-700 pl-4 pr-10 py-2.5 rounded-lg text-sm font-medium focus:ring-emerald-500 focus:border-emerald-500 shadow-sm outline-none cursor-pointer transition-colors hover:bg-slate-50">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                    </select>

                    @if(request('status') || request('sort'))
                    <a href="{{ url()->current() }}" class="inline-flex items-center justify-center bg-rose-50 border border-rose-200 text-rose-600 px-3 py-2.5 rounded-lg text-sm font-bold hover:bg-rose-100 hover:text-rose-800 transition-colors shadow-sm w-full sm:w-auto" title="Reset Filter">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span class="sm:hidden ml-2">Reset Filter</span>
                    </a>
                    @endif
                </form>

                <button @click="isModalOpen = true" type="button" class="w-full lg:w-auto inline-flex items-center justify-center gap-2 bg-slate-900 hover:bg-slate-800 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Buat Transaksi Baru
                </button>

            </div>
        </header>

        <section aria-label="Tabel Daftar Work Order" class="bg-white rounded-xl border border-slate-300 shadow-sm w-full min-w-0 overflow-hidden relative flex flex-col">
            <div class="overflow-x-auto w-full max-w-full">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead class="bg-slate-200 text-slate-700 text-xs uppercase tracking-wider">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-bold text-slate-700">Nama Perusahaan</th>
                            <th scope="col" class="px-6 py-4 font-bold text-slate-700">Pekerjaan</th>
                            <th scope="col" class="px-6 py-4 font-bold text-slate-700 text-center">Status</th>
                            <th scope="col" class="px-6 py-4 font-bold text-slate-700 text-center">Estimasi Selesai</th>
                            <th scope="col" class="px-6 py-4 font-bold text-slate-700 text-right">Total Biaya</th>
                            <th scope="col" class="px-6 py-4 font-bold text-slate-700 text-center">Aksi</th>
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
                                <span class="px-3 py-1 rounded-md text-[11px] font-bold uppercase {{ $statusColor }} whitespace-nowrap">
                                    {{ $wo->status }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                @if($wo->estimasi_selesai)
                                <div class="text-sm font-medium text-slate-700">
                                    {{ \Carbon\Carbon::parse($wo->estimasi_selesai)->translatedFormat('d M Y') }}
                                </div>
                                @else
                                <span class="text-[11px] text-slate-400 italic">Belum diset</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-700">Rp {{ number_format($wo->total_cost, 0, ',', '.') }}</div>
                                <div class="text-[11px] text-slate-500 mt-0.5 mb-2">Dibayar: Rp {{ number_format($wo->paid_amount, 0, ',', '.') }}</div>

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
                                <div class="flex justify-center items-center gap-1.5" role="group" aria-label="Aksi Work Order">

                                    <a href="{{ route('work_orders.invoice', $wo->id) }}" target="_blank"
                                        class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        aria-label="Cetak Invoice" title="Cetak Invoice">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                        </svg>
                                        <span class="sr-only">Cetak Invoice</span>
                                    </a>

                                    <div x-data="{ isEditOpen: false }" class="inline-block">
                                        <button @click="isEditOpen = true" type="button"
                                            class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                            aria-label="Edit Work Order" title="Edit Work Order">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            <span class="sr-only">Edit Work Order</span>
                                        </button>

                                        <div x-show="isEditOpen" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden p-4 sm:p-6 lg:p-8 text-left" role="dialog" aria-modal="true">
                                            <div x-show="isEditOpen" x-transition.opacity @click="isEditOpen = false" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm"></div>

                                            <div x-show="isEditOpen" x-transition class="relative bg-white rounded-2xl shadow-xl w-full max-w-5xl mx-auto overflow-hidden font-poppins flex flex-col max-h-[90vh] z-50">
                                                <header class="flex items-start sm:items-center justify-between px-5 sm:px-8 py-5 sm:py-6 border-b border-slate-100 bg-white sticky top-0">
                                                    <div>
                                                        <h2 class="text-lg sm:text-xl font-bold text-slate-800">Edit Work Order: {{ $wo->wo_number }}</h2>
                                                    </div>
                                                    <button type="button" @click="isEditOpen = false" class="text-slate-400 hover:text-slate-600 p-2 rounded-lg hover:bg-slate-50 shrink-0 ml-4">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </header>

                                                <div class="overflow-y-auto p-5 sm:p-8">
                                                    <form id="editForm{{ $wo->id }}" action="{{ route('work_orders.update', $wo->id) }}" method="POST" class="space-y-8">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="flex flex-col md:flex-row w-full gap-8 md:gap-0">
                                                            <fieldset class="w-full md:w-1/2 md:pr-8 space-y-5 sm:space-y-7">
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

                                                            <fieldset class="w-full md:w-1/2 md:pl-8 space-y-5 sm:space-y-7 md:border-l border-slate-200">
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
                                                                    <label class="block text-sm font-medium text-slate-700 mb-2">Estimasi Selesai <span class="text-slate-400 font-normal text-xs">(Opsional)</span></label>
                                                                    <input type="date" name="estimasi_selesai" value="{{ $wo->estimasi_selesai ? \Carbon\Carbon::parse($wo->estimasi_selesai)->format('Y-m-d') : '' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 outline-none transition-all">
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

                                                <footer class="flex flex-col-reverse sm:flex-row items-center justify-end gap-3 px-5 sm:px-8 py-5 sm:py-6 border-t border-slate-100 bg-slate-50 sticky bottom-0">
                                                    <button type="button" @click="isEditOpen = false" class="w-full sm:w-auto px-5 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800 transition-colors">
                                                        Batal
                                                    </button>
                                                    <button form="editForm{{ $wo->id }}" type="submit" class="w-full sm:w-auto bg-emerald-500 hover:bg-emerald-600 text-white px-8 py-2.5 rounded-xl text-sm font-bold transition-all shadow-md shadow-emerald-100 text-center">
                                                        Update Data
                                                    </button>
                                                </footer>
                                            </div>
                                        </div>
                                    </div>

                                    <form action="{{ route('work_orders.destroy', $wo->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data Work Order ini? Semua data relasi (termasuk penggunaan sparepart) akan ikut terhapus.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-rose-500"
                                            aria-label="Hapus Work Order" title="Hapus Work Order">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            <span class="sr-only">Hapus Work Order</span>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-14 text-center text-sm text-slate-500">
                                @if(request('status') || request('sort'))
                                Tidak ada data Work Order yang sesuai dengan filter.
                                @else
                                Belum ada data work order yang terdaftar.
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($workOrders, 'hasPages') && $workOrders->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                {{ $workOrders->links() }}
            </div>
            @endif

        </section>

        <div x-show="isModalOpen"
            style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden p-4 sm:p-6 lg:p-8"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">

            <div x-show="isModalOpen"
                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                @click="isModalOpen = false"
                class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"></div>

            <div x-show="isModalOpen"
                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative bg-white rounded-2xl shadow-xl w-full max-w-5xl mx-auto overflow-hidden font-poppins flex flex-col max-h-[90vh] z-50">

                <header class="flex items-start sm:items-center justify-between px-5 sm:px-8 py-5 sm:py-6 border-b border-slate-100 bg-white sticky top-0">
                    <div>
                        <h2 id="modal-headline" class="text-lg sm:text-xl font-bold text-slate-800">Buat Transaksi Baru</h2>
                        <p class="text-xs text-slate-500 mt-1">Gunakan formulir ini untuk mendaftarkan pengerjaan teknis baru dari pelanggan.</p>
                    </div>
                    <button type="button" @click="isModalOpen = false" class="text-slate-400 hover:text-slate-600 p-2 rounded-lg hover:bg-slate-50 shrink-0 ml-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </header>

                <div class="overflow-y-auto p-5 sm:p-8">
                    <form id="workOrderForm" action="{{ route('work_orders.store') }}" method="POST" class="space-y-8">
                        @csrf

                        <div class="flex flex-col md:flex-row w-full gap-8 md:gap-0">

                            <fieldset class="w-full md:w-1/2 md:pr-8 space-y-5 sm:space-y-7">
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

                            <fieldset class="w-full md:w-1/2 md:pl-8 space-y-5 sm:space-y-7 md:border-l border-slate-200">
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
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Estimasi Selesai <span class="text-slate-400 font-normal text-xs">(Opsional)</span></label>
                                    <input type="date" name="estimasi_selesai" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 outline-none transition-all">
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

                <footer class="flex flex-col-reverse sm:flex-row items-center justify-end gap-3 px-5 sm:px-8 py-5 sm:py-6 border-t border-slate-100 bg-slate-50 sticky bottom-0">
                    <button type="button" @click="isModalOpen = false" class="w-full sm:w-auto px-5 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800 transition-colors">
                        Batal
                    </button>
                    <button form="workOrderForm" type="submit" class="w-full sm:w-auto bg-emerald-500 hover:bg-emerald-600 text-white px-8 py-2.5 rounded-xl text-sm font-bold transition-all shadow-md shadow-emerald-100 text-center">
                        Simpan
                    </button>
                </footer>
            </div>
        </div>

        <datalist id="customer_list">
            @foreach($customers as $customer)
            <option value="{{ $customer->company_name }}"></option>
            @endforeach
        </datalist>

    </main>
</x-app-layout>