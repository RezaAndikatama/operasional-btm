<?php

namespace App\Http\Controllers;

use App\Models\Technician;
use Illuminate\Http\Request;

class TechnicianController extends Controller
{
    // 1. Menampilkan Halaman (Hanya Membaca) - DIBUKA UNTUK ADMIN
    public function index()
    {
        // Fitur ini sekarang bisa diakses oleh Admin dan Manajer
        $technicians = Technician::latest()->get();
        return view('technicians.technicians', compact('technicians'));
    }

    // 2. Menyimpan Data Baru - TETAP DIBLOKIR UNTUK ADMIN
    public function store(Request $request)
    {
        abort_if(auth()->user()->hasAnyRole(['admin', 'Admin']), 403, 'Akses Ditolak: Admin tidak diizinkan menambah data karyawan.');

        $request->validate([
            'name'           => 'required|string|max:255',
            'tempat_tinggal' => 'nullable|string|max:255',
            'umur'           => 'nullable|integer|min:17|max:100',
            'status'         => 'required|in:Aktif,Cuti',
        ]);

        Technician::create([
            'name'           => $request->name,
            'tempat_tinggal' => $request->tempat_tinggal,
            'umur'           => $request->umur,
            'status'         => $request->status,
        ]);

        return redirect()->route('technicians.index')->with('success', 'Data Karyawan berhasil ditambahkan!');
    }

    // 3. Menghapus Data 
    public function destroy($id)
    {
        abort_if(auth()->user()->hasAnyRole(['admin', 'Admin']), 403, 'Akses Ditolak: Admin tidak diizinkan menghapus data karyawan.');

        Technician::findOrFail($id)->delete();
        return redirect()->route('technicians.index')->with('success', 'Data Karyawan berhasil dihapus!');
    }

    // 4. Memperbarui Data (Edit) 
    public function update(Request $request, $id)
    {
        abort_if(auth()->user()->hasAnyRole(['admin', 'Admin']), 403, 'Akses Ditolak: Admin tidak diizinkan mengubah data karyawan.');

        $request->validate([
            'name'           => 'required|string|max:255',
            'tempat_tinggal' => 'nullable|string|max:255',
            'umur'           => 'nullable|integer|min:17|max:100',
            'status'         => 'required|in:Aktif,Cuti',
        ]);

        $technician = Technician::findOrFail($id);

        $technician->update([
            'name'           => $request->name,
            'tempat_tinggal' => $request->tempat_tinggal,
            'umur'           => $request->umur,
            'status'         => $request->status,
        ]);

        return redirect()->route('technicians.index')->with('success', 'Data Karyawan berhasil diperbarui!');
    }
}
