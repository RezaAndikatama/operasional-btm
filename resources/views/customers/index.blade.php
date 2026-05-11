<x-app-layout>
    <div class="p-6 sm:p-10 space-y-6">
        <div class="flex flex-col space-y-4 md:space-y-0 md:flex-row justify-between items-center">
            <div class="mr-6">
                <h1 class="text-2xl font-bold text-slate-900 font-poppins">Data Pelanggan</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola daftar perusahaan klien PT. Briliant Teknik Mandiri.</p>
            </div>

            <a href="{{ route('customers.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium rounded-xl transition-colors shadow-sm gap-2">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Pelanggan
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-200 text-xs font-bold text-slate-700 uppercase tracking-wider">
                            <th class="py-4 px-6">Nama Perusahaan</th>
                            <th class="py-4 px-6">Contact Person (PIC)</th>
                            <th class="py-4 px-6">Kontak</th>
                            <th class="py-4 px-6">Alamat</th>
                            <th class="py-4 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-100 text-slate-700">
                        @forelse ($customers as $customer)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-4 px-6 font-medium text-slate-900">{{ $customer->company_name }}</td>
                            <td class="py-4 px-6">{{ $customer->pic_name }}</td>
                            <td class="py-4 px-6">
                                <div class="flex flex-col">
                                    <span>{{ $customer->phone }}</span>
                                    <span class="text-xs text-slate-400">{{ $customer->email ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="truncate max-w-xs text-slate-500" title="{{ $customer->address }}">
                                    {{ $customer->address ?? '-' }}
                                </div>
                            </td>

                            {{-- KOLOM AKSI (IKON SEMANTIK) --}}
                            <td class="py-4 px-6">
                                <div class="flex justify-center items-center gap-1.5" role="group" aria-label="Aksi Pelanggan">

                                    {{-- Tombol Edit (Icon Pensil) --}}
                                    <button type="button" onclick="openEditModal({{ $customer }})"
                                        class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                        aria-label="Edit Pelanggan" title="Edit Data Pelanggan">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        <span class="sr-only">Edit</span>
                                    </button>

                                    {{-- Tombol Hapus (Icon Trash) --}}
                                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data perusahaan {{ $customer->company_name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-rose-500"
                                            aria-label="Hapus Pelanggan" title="Hapus Data Pelanggan">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            <span class="sr-only">Hapus</span>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-slate-500">
                                Belum ada data pelanggan yang terdaftar.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 sm:p-6 transition-opacity">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-xl overflow-hidden transform transition-all">

            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <h3 class="text-lg font-bold text-slate-800 font-poppins">Edit Data Pelanggan</h3>
                <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 focus:outline-none rounded-lg p-1 hover:bg-slate-200 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="editForm" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Nama Perusahaan <span class="text-red-500">*</span></label>
                        <input type="text" id="edit_company_name" name="company_name" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Contact Person (PIC) <span class="text-red-500">*</span></label>
                        <input type="text" id="edit_pic_name" name="pic_name" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Nomor Telepon <span class="text-red-500">*</span></label>
                        <input type="text" id="edit_phone" name="phone" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Alamat Email</label>
                        <input type="email" id="edit_email" name="email" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Alamat Lengkap</label>
                    <textarea id="edit_address" name="address" rows="3" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm outline-none"></textarea>
                </div>

                <div class="pt-4 flex justify-end space-x-3 border-t border-slate-100 mt-6">
                    <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-medium rounded-xl shadow-sm transition-colors text-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(customer) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');

            // Ubah URL tujuan form sesuai ID pelanggan
            form.action = `/customers/${customer.id}`;

            // Isi form dengan data yang ada
            document.getElementById('edit_company_name').value = customer.company_name;
            document.getElementById('edit_pic_name').value = customer.pic_name;
            document.getElementById('edit_phone').value = customer.phone;
            document.getElementById('edit_email').value = customer.email || '';
            document.getElementById('edit_address').value = customer.address || '';

            // Munculkan Modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</x-app-layout>