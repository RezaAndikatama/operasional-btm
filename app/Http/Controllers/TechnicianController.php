<?php

namespace App\Http\Controllers;

use App\Models\Technician;
use Illuminate\Http\Request;

class TechnicianController extends Controller
{
    // 1. Menampilkan Halaman & Tabel Data
    public function index()
    {
        $technicians = Technician::latest()->get();
        return view('technicians', compact('technicians'));
    }

    // 2. Menyimpan Data Baru
    public function store(Request $request)
    {
        // PERHATIKAN BARIS STATUS: Tidak boleh ada spasi setelah tanda koma!
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
        Technician::findOrFail($id)->delete();
        return redirect()->route('technicians.index')->with('success', 'Data Karyawan berhasil dihapus!');
    }

    // 4. Memperbarui Data (Edit)
    public function update(Request $request, $id)
    {
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
