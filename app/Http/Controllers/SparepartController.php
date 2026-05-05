<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use Illuminate\Http\Request;

class SparepartController extends Controller
{
    public function index()
    {
        $spareparts = Sparepart::orderBy('name', 'asc')->get();
        return view('spareparts.index', compact('spareparts'));
    }

    public function store(Request $request)
    {
        // 1. Validasi input dari form
        $request->validate([
            'name'  => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'price' => 'nullable|numeric|min:0',
            'unit' => 'required|string|max:50',
        ]);

        // 2. Buat Kode SKU Otomatis (Format: SP-TahunBulanTanggal-AngkaAcak)
        $generateSku = 'SP-' . date('Ymd') . '-' . rand(1000, 9999);

        // 3. Simpan data ke database beserta SKU-nya secara manual (Bukan pakai $request->all())
        Sparepart::create([
            'name'     => $request->name,
            'stock'    => $request->stock,
            'price'    => $request->price,
            'unit'     => $request->unit,
        ]);

        return redirect()->route('spareparts.index')->with('success', 'Bahan baku berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'price' => 'nullable|numeric|min:0',
            'unit'  => 'required|string|max:50',
        ]);

        $sparepart = Sparepart::findOrFail($id);
        $sparepart->update($request->all());

        return redirect()->route('spareparts.index')->with('success', 'Bahan baku berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $sparepart = Sparepart::findOrFail($id);
        $sparepart->delete();

        return redirect()->route('spareparts.index')->with('success', 'Bahan baku berhasil dihapus!');
    }
}
