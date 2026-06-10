<x-app-layout>
    <div class="w-full space-y-6 font-poppins"
        x-data="{ isModalOpen: {{ $errors->any() ? 'true' : 'false' }}, isEditOpen: false }"
        @open-edit-modal.window="isEditOpen = true"
        @close-edit-modal.window="isEditOpen = false">

        @if(session('success'))
        <div role="alert" class="p-4 bg-emerald-50 text-emerald-600 rounded-lg border border-emerald-200 text-sm font-medium">
            {{ session('success') }}
        </div>
        @endif

        <header class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Data Karyawan</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola daftar karyawan PT. Briliant Teknik Mandiri.</p>
            </div>

            @unlessrole('admin|Admin')
            <button @click="isModalOpen = true" class="bg-slate-900 text-white px-5 py-2.5 rounded-lg hover:bg-slate-800 hover:shadow-lg transition flex items-center gap-2 text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Karyawan
            </button>
            @endunlessrole
        </header>

        <section aria-label="Tabel Data Karyawan" class="bg-white rounded-xl shadow-sm border border-slate-300 flex flex-col">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-200 text-slate-700 text-xs uppercase tracking-wider">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-bold">NAMA LENGKAP</th>
                            <th scope="col" class="px-6 py-4 font-bold">TEMPAT TINGGAL</th>
                            <th scope="col" class="px-6 py-4 font-bold">UMUR</th>
                            <th scope="col" class="px-6 py-4 font-bold">STATUS</th>
                            @unlessrole('admin|Admin')
                            <th scope="col" class="px-6 py-4 font-bold text-center">AKSI</th>
                            @endunlessrole
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-100">
                        @forelse($technicians as $tech)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-800">{{ $tech->name }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $tech->tempat_tinggal ?? '-' }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $tech->umur ? $tech->umur . ' Tahun' : '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 {{ $tech->status == 'Aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }} rounded-full text-[10px] font-bold uppercase tracking-wide whitespace-nowrap">
                                    {{ $tech->status }}
                                </span>
                            </td>

                            @unlessrole('admin|Admin')
                            <td class="px-6 py-4">
                                <div class="flex justify-center items-center gap-1.5" role="group" aria-label="Aksi Karyawan">
                                    <button type="button" onclick="openEditModal({{ $tech }})"
                                        class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>

                                    <form action="{{ route('technicians.destroy', $tech->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data teknisi ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-rose-500">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            @endunlessrole
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-14 text-center text-sm text-slate-500">Belum ada data teknisi. Silakan klik "Tambah Karyawan".</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

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
                    <h2 class="text-xl font-bold text-slate-800">Tambah Karyawan Baru</h2>
                    <button type="button" @click="isModalOpen = false" class="text-slate-400 hover:text-slate-600 p-2 rounded-lg hover:bg-slate-50 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </header>

                <div class="p-6">
                    @if ($errors->any())
                    <div role="alert" class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-4 text-sm font-medium">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('technicians.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                            <input name="name" type="text" value="{{ old('name') }}" class="w-full rounded-xl border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Tempat Tinggal</label>
                            <textarea name="tempat_tinggal" rows="2" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm bg-slate-50 focus:ring-emerald-500 focus:border-emerald-500">{{ old('tempat_tinggal') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Umur (Tahun)</label>
                            <input type="number" name="umur" value="{{ old('umur') }}" min="17" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm bg-slate-50 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                            <select name="status" class="w-full rounded-xl border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500" required>
                                <option value="">Pilih Status...</option>
                                <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Cuti" {{ old('status') == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                            </select>
                        </div>
                        <div class="mt-8 flex justify-end gap-3 border-t border-slate-100 pt-5">
                            <button type="button" @click="isModalOpen = false" class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-xl transition-colors">Batal</button>
                            <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold transition shadow-sm">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div x-show="isEditOpen"
            style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden p-4 sm:p-6 lg:p-8"
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
                    <h2 class="text-xl font-bold text-slate-800">Edit Data Teknisi</h2>
                    <button type="button" @click="isEditOpen = false" class="text-slate-400 hover:text-slate-600 p-2 rounded-lg hover:bg-slate-50 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </header>

                <div class="p-6">
                    <form id="editForm" method="POST" class="space-y-4">
                        @csrf @method('PUT')
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                            <input id="edit_name" name="name" type="text" class="w-full rounded-xl border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Tempat Tinggal</label>
                            <textarea id="edit_tempat_tinggal" name="tempat_tinggal" rows="2" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm bg-slate-50 focus:ring-emerald-500 focus:border-emerald-500"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Umur (Tahun)</label>
                            <input type="number" id="edit_umur" name="umur" min="17" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm bg-slate-50 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                            <select id="edit_status" name="status" class="w-full rounded-xl border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Cuti">Cuti</option>
                            </select>
                        </div>
                        <div class="mt-8 flex justify-end gap-3 border-t border-slate-100 pt-5">
                            <button type="button" @click="isEditOpen = false" class="px-5 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-xl transition-colors">Batal</button>
                            <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold transition shadow-sm">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script>
        function openEditModal(tech) {
            document.getElementById('editForm').action = `{{ url('technicians') }}/${tech.id}`;
            document.getElementById('edit_name').value = tech.name;
            document.getElementById('edit_tempat_tinggal').value = tech.tempat_tinggal;
            document.getElementById('edit_umur').value = tech.umur;
            document.getElementById('edit_status').value = tech.status;

            // Perintah untuk memerintahkan Alpine.js membuka modal Edit
            window.dispatchEvent(new Event('open-edit-modal'));
        }
    </script>
</x-app-layout>