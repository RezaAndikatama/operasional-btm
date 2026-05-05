<x-app-layout>
    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto" x-data="{ isModalOpen: false }">

        @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-50 text-emerald-600 rounded-lg border border-emerald-200 text-sm font-medium">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 text-red-600 rounded-lg border border-red-200 text-sm font-medium">
            {{ session('error') }}
        </div>
        @endif

        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Manajemen Pengguna</h2>
                <p class="text-sm text-slate-500">Kelola akun dan pangkat (role) untuk akses sistem operasional.</p>
            </div>
            <button @click="isModalOpen = true" class="bg-slate-900 text-white px-5 py-2.5 rounded-lg hover:bg-slate-800 hover:shadow-lg transition flex items-center gap-2 text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                Tambah User
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-200 text-slate-600 uppercase font-semibold text-xs border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4">Nama User</th>
                            <th class="px-6 py-4">Email Login</th>
                            <th class="px-6 py-4">Hak Akses (Role)</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($users as $user)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                @if($user->roles->count() > 0)
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-600 border border-indigo-200 uppercase tracking-wide">
                                    {{ $user->roles->first()->name }}
                                </span>
                                @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-500 border border-slate-200 uppercase tracking-wide">
                                    Belum Ada
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right font-medium" x-data="{ isEditOpen: false }">
                                <div class="flex justify-end gap-3">
                                    <button @click="isEditOpen = true" class="text-emerald-600 hover:underline">Edit</button>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </div>

                                <div x-show="isEditOpen" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 text-left">
                                    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-xl w-full max-w-md" @click.away="isEditOpen = false">
                                        <h3 class="text-xl font-bold mb-6 text-slate-800">Edit Data Pengguna</h3>

                                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="space-y-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                                                    <input name="name" type="text" value="{{ $user->name }}" class="w-full rounded-lg border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500" required>
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                                                    <input name="email" type="email" value="{{ $user->email }}" class="w-full rounded-lg border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500" required>
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium text-slate-700 mb-1">Hak Akses (Role)</label>
                                                    <select name="role" class="w-full rounded-lg border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500" required>
                                                        @foreach($roles as $role)
                                                        <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                            {{ ucfirst($role->name) }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium text-slate-700 mb-1">Password Baru <span class="text-xs text-slate-400 font-normal">(Kosongkan jika tidak ingin diubah)</span></label>
                                                    <input name="password" type="password" class="w-full rounded-lg border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500" minlength="8">
                                                </div>
                                            </div>

                                            <div class="mt-8 flex justify-end gap-3">
                                                <button type="button" @click="isEditOpen = false" class="px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-lg transition">Batal</button>
                                                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded-lg text-sm font-medium transition shadow-sm">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
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
        </div>

        <div x-show="isModalOpen" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4 text-left">
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-xl w-full max-w-md" @click.away="isModalOpen = false">
                <h3 class="text-xl font-bold mb-6 text-slate-800">Tambah Akun Baru</h3>

                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                            <input name="name" type="text" class="w-full rounded-lg border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Email Login</label>
                            <input name="email" type="email" class="w-full rounded-lg border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Hak Akses (Role)</label>
                            <select name="role" class="w-full rounded-lg border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500" required>
                                <option value="" disabled selected>Pilih Pangkat...</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                            <input name="password" type="password" class="w-full rounded-lg border-slate-200 text-sm focus:ring-emerald-500 focus:border-emerald-500" required minlength="8">
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-3">
                        <button type="button" @click="isModalOpen = false" class="px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-lg transition">Batal</button>
                        <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-5 py-2 rounded-lg text-sm font-medium transition shadow-sm">Simpan Akun</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>