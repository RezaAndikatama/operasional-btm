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
                        <tr class="bg-slate-200 text-xs font-bold text-slate-600 uppercase tracking-wider">
                            <th class="py-4 px-6">Nama Perusahaan</th>
                            <th class="py-4 px-6">Contact Person (PIC)</th>
                            <th class="py-4 px-6">Kontak</th>
                            <th class="py-4 px-6">Alamat</th>
                            <th class="py-4 px-6 text-right">Aksi</th>
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

                            <td class="py-4 px-6 text-right space-x-3">
                                <button type="button" onclick="openEditModal({{ $customer }})" class="font-medium text-emerald-600 hover:text-emerald-700 transition-colors">
                                    Edit
                                </button>

                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data perusahaan {{ $customer->company_name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-red-600 hover:text-red-700 transition-colors">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-10 text-center text-slate-500">
                                Belum ada data pelanggan yang terdaftar.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- PopUp Edit -->
    <div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 sm:p-6 transition-opacity">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-xl overflow-hidden transform transition-all">

            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <h3 class="text-lg font-bold text-slate-800 font-poppins">Edit Data Pelanggan</h3>
                <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600">
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