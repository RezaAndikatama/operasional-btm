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
            @unlessrole('admin|Admin')
            <button @click="isModalOpen = true" class="bg-slate-900 text-white px-5 py-2.5 rounded-lg hover:bg-slate-800 hover:shadow-lg transition flex items-center gap-2 text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Karyawan
            </button>
            @endunlessrole
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-300 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-200 text-slate-700 text-xs uppercase tracking-wider">
                            <th class="px-6 py-4 font-bold">NAMA LENGKAP</th>
                            <th class="px-6 py-4 font-bold">TEMPAT TINGGAL</th>
                            <th class="px-6 py-4 font-bold">UMUR</th>
                            <th class="px-6 py-4 font-bold">STATUS</th>
                            @unlessrole('admin|Admin')
                            <th class="px-6 py-4 font-bold text-center">AKSI</th>
                            @endunlessrole
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-50">
                        @forelse($technicians as $tech)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-800">{{ $tech->name }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $tech->tempat_tinggal ?? '-' }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $tech->umur ? $tech->umur . ' Tahun' : '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 {{ $tech->status == 'Aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }} rounded-full text-[10px] font-bold uppercase tracking-wide whitespace-nowrap">
                                    {{ $tech->status }}
                                </span>
                            </td>

                            <!-- Kolom Aksi -->
                            @unlessrole('admin|Admin')
                            <td class="px-6 py-4">
                                <div class="flex justify-center items-center gap-1.5" role="group" aria-label="Aksi Karyawan">
                                    <!-- Button Edit -->
                                    <button type="button" onclick="openEditModal({{ $tech }})"
                                        class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                        aria-label="Edit Karyawan" title="Edit Data Karyawan">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        <span class="sr-only">Edit</span>
                                    </button>

                                    <!-- Button Delete -->
                                    <form action="{{ route('technicians.destroy', $tech->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data teknisi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-rose-500"
                                            aria-label="Hapus Karyawan" title="Hapus Data Karyawan">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            <span class="sr-only">Hapus</span>
                                        </button>
                                    </form>

                                </div>
                            </td>
                            @endunlessrole

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
                            {{-- UPDATE: Pilihan status Create form --}}
                            <select name="status" class="w-full rounded-xl border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500" required>
                                <option value="">Pilih Status...</option>
                                <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Cuti" {{ old('status') == 'Cuti' ? 'selected' : '' }}>Cuti</option>
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
                            {{-- UPDATE: Pilihan status Edit form --}}
                            <select id="edit_status" name="status" class="w-full rounded-xl border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Cuti">Cuti</option>
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