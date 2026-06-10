<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    // 1. Menampilkan Halaman & Data User
    public function index()
    {
        // Mengambil data beserta roles
        $users = User::with('roles')->latest()->get();
        // Mengambil daftar roles yang tersedia untuk dropdown form
        $roles = Role::all();

        return view('users.users', compact('users', 'roles'));
    }

    // 2. Menyimpan User Baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Beri pangkat/role kepada user baru tersebut
        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'User baru berhasil ditambahkan!');
    }

    // 3. Mengubah Data User
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        // Hanya update password jika kolom diisi (tidak kosong)
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Sinkronisasi (ganti) pangkat yang lama dengan yang baru
        $user->syncRoles($request->role);

        return redirect()->route('users.index')->with('success', 'Data User berhasil diperbarui!');
    }

    // 4. Menghapus User
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Fitur Keamanan: Mencegah admin menghapus akunnya sendiri yang sedang dipakai
        if (Auth::id() == $id) {
            return redirect()->route('users.index')->with('error', 'Anda tidak dapat menghapus akun yang sedang Anda gunakan!');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }
}
