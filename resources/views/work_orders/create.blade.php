<x-app-layout>
    {{-- Main sebagai area konten utama --}}
    <main class="py-12 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto">

        {{-- Header untuk judul halaman --}}
        <header class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 font-poppins">Pencatatan Work Order Baru</h1>
                <p class="text-sm text-slate-500 mt-1">Gunakan formulir ini untuk mendaftarkan pengerjaan teknis baru dari pelanggan.</p>
            </div>
            <nav aria-label="Breadcrumb">
                <a href="{{ route('work_orders.index') }}" class="text-sm font-medium text-slate-600 hover:text-emerald-600 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Daftar
                </a>
            </nav>
        </header>

        {{-- Section untuk membungkus form utama --}}
        <section class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <form action="{{ route('work_orders.store') }}" method="POST" class="p-8 space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    {{-- Fieldset untuk mengelompokkan input terkait --}}
                    <fieldset class="space-y-6">
                        <legend class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4">Data Utama Pekerjaan</legend>

                        <div>
                            <label for="customer_id" class="block text-sm font-medium text-slate-700 mb-2">Pilih Perusahaan / Pelanggan <span class="text-red-500">*</span></label>
                            <select id="customer_id" name="customer_id" required class="w-full px-4 py-3 rounded-xl border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 outline-none transition-all">
                                <option value="" disabled selected>-- Cari Nama Perusahaan --</option>
                                @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->company_name }} — (PIC: {{ $customer->pic_name }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="job_name" class="block text-sm font-medium text-slate-700 mb-2">Judul Pekerjaan / Project <span class="text-red-500">*</span></label>
                            <input type="text" id="job_name" name="job_name" placeholder="Contoh: Perbaikan Panel Listrik Ruang A" required
                                class="w-full px-4 py-3 rounded-xl border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 outline-none transition-all">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-slate-700 mb-2">Deskripsi Kerusakan / Instruksi</label>
                            <textarea id="description" name="description" rows="4" placeholder="Jelaskan detail pengerjaan..."
                                class="w-full px-4 py-3 rounded-xl border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 outline-none transition-all"></textarea>
                        </div>
                    </fieldset>

                    {{-- Fieldset kedua untuk bagian keuangan dan status pekerjaan --}}
                    <fieldset class="space-y-6">
                        <legend class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4">Administrasi & Biaya</legend>

                        <div>
                            <label for="status" class="block text-sm font-medium text-slate-700 mb-2">Status Pekerjaan</label>
                            <select id="status" name="status" required class="w-full px-4 py-3 rounded-xl border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 outline-none transition-all">
                                <option value="Pending">Pending (Menunggu Antrean)</option>
                                <option value="Sedang Dikerjakan">Sedang Dikerjakan</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>

                        {{-- Field: Total Biaya --}}
                        <div>
                            <label for="total_cost" class="block text-sm font-medium text-slate-700 mb-2">Total Biaya (Invoice) <span class="text-red-500">*</span></label>
                            <div class="flex">
                                {{-- Kotak Label Rp di Samping Kiri --}}
                                <span class="inline-flex items-center px-4 rounded-l-xl border border-r-0 border-slate-200 bg-slate-100 text-slate-500 text-sm font-semibold">
                                    Rp
                                </span>
                                {{-- Input Field dengan rounded-r (hanya bulat di kanan) --}}
                                <input type="number" id="total_cost" name="total_cost" placeholder="0" required
                                    class="flex-1 w-full px-4 py-3 rounded-r-xl border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 outline-none transition-all">
                            </div>
                        </div>

                        {{-- Field: Sudah Dibayar --}}
                        <div class="mt-6">
                            <label for="paid_amount" class="block text-sm font-medium text-slate-700 mb-2">Sudah Dibayar / DP <span class="text-red-500">*</span></label>
                            <div class="flex">
                                {{-- Kotak Label Rp di Samping Kiri --}}
                                <span class="inline-flex items-center px-4 rounded-l-xl border border-r-0 border-slate-200 bg-slate-100 text-slate-500 text-sm font-semibold">
                                    Rp
                                </span>
                                {{-- Input Field dengan rounded-r (hanya bulat di kanan) --}}
                                <input type="number" id="paid_amount" name="paid_amount" placeholder="0" required
                                    class="flex-1 w-full px-4 py-3 rounded-r-xl border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500 bg-slate-50 outline-none transition-all">
                            </div>
                        </div>
                    </fieldset>
                </div>

                {{-- Footer --}}
                <footer class="pt-8 border-t border-slate-100 flex items-center justify-end gap-4">
                    <button type="reset" class="px-6 py-3 text-sm font-medium text-slate-500 hover:text-slate-700 transition-colors">
                        Reset Form
                    </button>
                    <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-2xl text-sm font-semibold transition-all shadow-lg shadow-emerald-100 flex items-center gap-2">
                        Simpan
                    </button>
                </footer>
            </form>
        </section>
    </main>
</x-app-layout>