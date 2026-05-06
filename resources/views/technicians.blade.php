<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto" x-data="{ isModalOpen: {{ $errors->any() ? 'true' : 'false' }} }">

        @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-50 text-emerald-600 rounded-lg border border-emerald-200 text-sm font-medium">
            {{ session('success') }}
        </div>
        @endif

        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Data Karyawan</h2>
                <p class="text-sm text-slate-500">Kelola daftar karyawan PT. Briliant Teknik Mandiri.</p>
            </div>
            <button @click="isModalOpen = true" class="bg-slate-900 text-white px-5 py-2.5 rounded-lg hover:bg-slate-800 hover:shadow-lg transition flex items-center gap-2 text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Karyawan
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-200 text-slate-700 text-xs uppercase tracking-wider">
                            <th class="px-6 py-4 font-bold">NAMA LENGKAP</th>
                            <th class="px-6 py-4 font-bold">TEMPAT TINGGAL</th>
                            <th class="px-6 py-4 font-bold">UMUR</th>
                            <th class="px-6 py-4 font-bold">STATUS</th>
                            <th class="px-6 py-4 font-bold text-right">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-50">
                        @forelse($technicians as $tech)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-bold text-slate-800">{{ $tech->name }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $tech->tempat_tinggal ?? '-' }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $tech->umur ? $tech->umur . ' Tahun' : '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 {{ $tech->status == 'Aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-700' }} rounded-full text-[10px] font-bold uppercase tracking-wide">
                                    {{ $tech->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right flex justify-end gap-3">
                                <button onclick="openEditModal({{ $tech }})" class="font-medium text-emerald-500 hover:text-emerald-700 transition">Edit</button>
                                <form action="{{ route('technicians.destroy', $tech->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-red-500 hover:text-red-700 transition" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                Belum ada data teknisi. Silakan klik "Tambah Karyawan".
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- PopUp Tambah Data Karyawan -->
        <div x-show="isModalOpen" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 sm:p-6 text-left transition-opacity">
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-xl w-full max-w-md" @click.away="isModalOpen = false">
                <h3 class="text-xl font-bold mb-6 text-slate-800 font-poppins">Tambah Karyawan Baru</h3>

                @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-4 text-sm font-medium">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('technicians.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                            <input name="name" type="text" value="{{ old('name') }}" class="w-full rounded-xl border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500" required>
                        </div>

                        <div class="mb-4">
                            <label for="tempat_tinggal" class="block text-sm font-bold text-slate-700 mb-1">Tempat Tinggal</label>
                            <textarea id="tempat_tinggal" name="tempat_tinggal" rows="2"
                                class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 bg-slate-50 focus:ring-emerald-500 focus:border-emerald-500">{{ old('tempat_tinggal') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="umur" class="block text-sm font-bold text-slate-700 mb-1">Umur (Tahun)</label>
                            <input type="number" id="umur" name="umur" value="{{ old('umur') }}" min="17"
                                class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 bg-slate-50 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                            <select name="status" class="w-full rounded-xl border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500" required>
                                <option value="">Pilih Status...</option>
                                <option value="Tersedia" {{ old('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="Sedang Tugas" {{ old('status') == 'Sedang Tugas' ? 'selected' : '' }}>Sedang Tugas</option>
                                <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-3 border-t border-slate-100 pt-5">
                        <button type="button" @click="isModalOpen = false" class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-xl transition-colors">Batal</button>
                        <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-2.5 rounded-xl text-sm font-medium transition shadow-sm">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- PopUp Edit Data Karyawan -->
        <div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 sm:p-6 text-left transition-opacity">
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-xl w-full max-w-md">
                <h3 class="text-xl font-bold mb-6 text-slate-800 font-poppins">Edit Data Teknisi</h3>

                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                            <input id="edit_name" name="name" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500" required>
                        </div>

                        <div class="mb-4">
                            <label for="edit_tempat_tinggal" class="block text-sm font-bold text-slate-700 mb-1">Tempat Tinggal</label>
                            <textarea id="edit_tempat_tinggal" name="tempat_tinggal" rows="2"
                                class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 bg-slate-50 focus:ring-emerald-500 focus:border-emerald-500"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="edit_umur" class="block text-sm font-bold text-slate-700 mb-1">Umur (Tahun)</label>
                            <input type="number" id="edit_umur" name="umur" min="17"
                                class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 bg-slate-50 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                            <select id="edit_status" name="status" class="w-full rounded-xl border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500" required>
                                <option value="Tersedia">Tersedia</option>
                                <option value="Sedang Tugas">Sedang Tugas</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-3 border-t border-slate-100 pt-5">
                        <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-xl transition-colors">Batal</button>
                        <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-2.5 rounded-xl text-sm font-medium transition shadow-sm">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        function openEditModal(tech) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');

            // Arahkan tujuan Form ke rute update teknisi
            form.action = `{{ url('technicians') }}/${tech.id}`;

            // Isi data inputan dengan data yang dipilih
            document.getElementById('edit_name').value = tech.name;
            document.getElementById('edit_tempat_tinggal').value = tech.tempat_tinggal;
            document.getElementById('edit_umur').value = tech.umur;
            document.getElementById('edit_status').value = tech.status;

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