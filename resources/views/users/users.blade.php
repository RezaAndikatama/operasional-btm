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
        @if(session('error'))
        <div role="alert" class="p-4 bg-red-50 text-red-600 rounded-lg border border-red-200 text-sm font-medium">
            {{ session('error') }}
        </div>
        @endif

        <header class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Manajemen Pengguna</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola akun dan pangkat (role) untuk akses sistem.</p>
            </div>
            <button @click="isModalOpen = true" class="bg-slate-900 text-white px-5 py-2.5 rounded-lg hover:bg-slate-800 hover:shadow-lg transition flex items-center gap-2 text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                Tambah User
            </button>
        </header>

        <section aria-label="Tabel Manajemen Pengguna" class="bg-white rounded-xl shadow-sm border border-slate-300 flex flex-col">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-200 text-slate-700 uppercase font-semibold text-xs border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4">Nama User</th>
                            <th class="px-6 py-4">Email Login</th>
                            <th class="px-6 py-4">Hak Akses (Role)</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($users as $user)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-slate-700">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                @if($user->roles->count() > 0)
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-600 border border-indigo-200 uppercase">{{ $user->roles->first()->name }}</span>
                                @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-500 border border-slate-200 uppercase">Belum Ada</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-3">
                                    <button type="button" onclick="openEditModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}')" class="p-2 text-slate-400 hover:text-emerald-600 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-500">Belum ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <template x-teleport="body">
            <div x-show="isModalOpen" style="display: none; z-index: 999999;" class="fixed inset-0 flex items-center justify-center p-4 font-poppins" role="dialog">

                <div x-show="isModalOpen" @click="isModalOpen = false" x-transition.opacity class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm"></div>

                <div x-show="isModalOpen" x-transition class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-md relative">
                    <h3 class="text-xl font-bold mb-6 text-slate-800">Tambah Akun Baru</h3>
                    <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div><label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label><input name="name" type="text" class="w-full rounded-lg border-slate-200 text-sm focus:ring-emerald-500" required></div>
                        <div><label class="block text-sm font-medium text-slate-700 mb-1">Email Login</label><input name="email" type="email" class="w-full rounded-lg border-slate-200 text-sm focus:ring-emerald-500" required></div>
                        <div><label class="block text-sm font-medium text-slate-700 mb-1">Hak Akses</label><select name="role" class="w-full rounded-lg border-slate-200 text-sm focus:ring-emerald-500" required>
                                @foreach($roles as $role)<option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>@endforeach
                            </select></div>

                        <div x-data="{ showPassword: false }">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                            <div class="relative">
                                <input :type="showPassword ? 'text' : 'password'" name="password" class="w-full rounded-lg border-slate-200 text-sm focus:ring-emerald-500 pr-10" required>
                                <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-emerald-600 focus:outline-none">
                                    <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <svg x-show="showPassword" style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.29 3.29m0 0a10.05 10.05 0 015.188-1.583c4.477 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="pt-4 flex justify-end gap-3"><button type="button" @click="isModalOpen = false" class="px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 rounded-lg">Batal</button><button type="submit" class="bg-emerald-500 text-white px-5 py-2 rounded-lg text-sm font-bold shadow-sm transition-colors hover:bg-emerald-600">Simpan</button></div>
                    </form>
                </div>
            </div>
        </template>

        <template x-teleport="body">
            <div x-show="isEditOpen" style="display: none; z-index: 999999;" class="fixed inset-0 flex items-center justify-center p-4 font-poppins" role="dialog">

                <div x-show="isEditOpen" @click="isEditOpen = false" x-transition.opacity class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm"></div>

                <div x-show="isEditOpen" x-transition class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-md relative">
                    <h3 class="text-xl font-bold mb-6 text-slate-800">Edit Data Pengguna</h3>

                    <form id="editForm" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                            <input id="edit_name" name="name" type="text" class="w-full rounded-lg border-slate-200 text-sm focus:ring-emerald-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Email Login</label>
                            <input id="edit_email" name="email" type="email" class="w-full rounded-lg border-slate-200 text-sm focus:ring-emerald-500" required>
                        </div>

                        <div x-data="{ showNew: false }">
                            <label class="block text-sm font-medium text-slate-700 mb-1">
                                Set Password Baru
                                <span class="text-xs text-slate-400 font-normal ml-1">(Kosongkan jika tidak diubah)</span>
                            </label>
                            <div class="relative">
                                <input :type="showNew ? 'text' : 'password'" name="password" class="w-full rounded-lg border-slate-200 text-sm focus:ring-emerald-500 pr-10" placeholder="Minimal 8 karakter">

                                <button type="button" @click="showNew = !showNew" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-emerald-600 focus:outline-none">
                                    <svg x-show="!showNew" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <svg x-show="showNew" style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.29 3.29m0 0a10.05 10.05 0 015.188-1.583c4.477 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="pt-4 flex justify-end gap-3">
                            <button type="button" @click="isEditOpen = false" class="px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 rounded-lg transition-colors">Batal</button>
                            <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-5 py-2 rounded-lg text-sm font-bold shadow-sm transition-colors">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

    </div>

    <script>
        function openEditModal(id, name, email) {
            document.getElementById('editForm').action = `/users/${id}`;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;

            window.dispatchEvent(new Event('open-edit-modal'));
        }
    </script>
</x-app-layout>