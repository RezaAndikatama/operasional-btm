<x-app-layout>
    <div class="w-full space-y-6 font-poppins">

        <header class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Tambah Pelanggan Baru</h1>
                <p class="text-sm text-slate-500 mt-1">Masukkan detail informasi perusahaan klien PT. Briliant Teknik Mandiri.</p>
            </div>
            <a href="{{ route('customers.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors">
                &larr; Kembali
            </a>
        </header>

        <section class="bg-white rounded-xl border border-slate-300 shadow-sm overflow-hidden">
            <form action="{{ route('customers.store') }}" method="POST" class="p-6 sm:p-8 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Nama Perusahaan <span class="text-red-500">*</span></label>
                        <input type="text" name="company_name" value="{{ old('company_name') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm outline-none" placeholder="Contoh: PT. Solid Energi">
                        @error('company_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Contact Person (PIC) <span class="text-red-500">*</span></label>
                        <input type="text" name="pic_name" value="{{ old('pic_name') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm outline-none" placeholder="Nama penanggung jawab">
                        @error('pic_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Nomor Telepon <span class="text-red-500">*</span></label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm outline-none" placeholder="Contoh: 08123456789">
                        @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm outline-none" placeholder="email@perusahaan.com">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Alamat Lengkap</label>
                    <textarea name="address" rows="3" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm outline-none">{{ old('address') }}</textarea>
                </div>

                <div class="pt-4 flex justify-end border-t border-slate-100">
                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-xl shadow-sm transition-colors text-sm">
                        Simpan Data Pelanggan
                    </button>
                </div>
            </form>
        </section>
    </div>
</x-app-layout>