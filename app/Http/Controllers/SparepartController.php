<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use App\Models\InventoryHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SparepartController extends Controller
{
    public function index(Request $request)
    {
        $spareparts = Sparepart::orderBy('name', 'asc')->get();

        // Mengambil Data WO yang belum selesai
        $workOrders = \App\Models\WorkOrder::where('status', '!=', 'Selesai')
            ->latest()
            ->get();

        return view('spareparts.index', compact('spareparts', 'workOrders'));
    }

    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'name'      => 'required|string|unique:spareparts,name',
            'stock'     => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'price'     => 'nullable|numeric|min:0',
            'unit'      => 'required|string|max:50',
        ], [
            // Error Message
            'name.unique' => 'Bahan baku ini sudah terdaftar! Gunakan tombol "Barang Masuk" untuk menambah stoknya.'
        ]);

        Sparepart::create([
            'name'      => $request->name,
            'stock'     => $request->stock,
            'min_stock' => $request->min_stock,
            'price'     => $request->price,
            'unit'      => $request->unit,
        ]);

        return redirect()->route('spareparts.index')->with('success', 'Bahan baku berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'stock'     => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'price'     => 'nullable|numeric|min:0',
            'unit'      => 'required|string|max:50',
        ]);

        $sparepart = Sparepart::findOrFail($id);
        $sparepart->update($request->all());

        return redirect()->route('spareparts.index')->with('success', 'Bahan baku berhasil diperbarui!');
    }

    // Update Stok Penggunaan
    public function updateStock(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name'   => 'required|string',
            'masuk'  => 'nullable|integer|min:0',
            'keluar' => 'nullable|integer|min:0',
            'wo'     => 'nullable|string|max:255',
        ]);

        // 2. Cari Bahan Baku yang diplih dari Datalist
        $sparepart = Sparepart::where('name', $request->name)->first();

        if (!$sparepart) {
            return redirect()->back()->with('error', 'Bahan baku tidak ditemukan. Pilih dari daftar yang ada.');
        }

        $masuk = intval($request->masuk ?? 0);
        $keluar = intval($request->keluar ?? 0);

        // 3. Cegah eksekusi jika form jumlah masuk & keluar sama-sama kosong
        if ($masuk == 0 && $keluar == 0) {
            return redirect()->back()->with('error', 'Silakan isi salah satu: Jumlah Masuk atau Jumlah Terpakai.');
        }

        // Fitur Keamanan: Cegah stok menjadi minus jika barang terpakai melebihi sisa stok
        if ($keluar > 0 && $sparepart->stock < $keluar) {
            return redirect()->back()->with('error', 'Gagal! Stok tidak mencukupi. Sisa stok saat ini hanya: ' . $sparepart->stock . ' ' . $sparepart->unit);
        }

        // Proses Simpan dengan DB Transaction agar sinkron
        DB::transaction(function () use ($sparepart, $masuk, $keluar, $request) {

            // A. Update stok di master data (tabel spareparts)
            $sparepart->stock += $masuk;
            $sparepart->stock -= $keluar;
            $sparepart->save();

            // B. Catat pergerakannya ke tabel riwayat (inventory_histories)
            InventoryHistory::create([
                'sparepart_id'      => $sparepart->id,
                'user_id'           => Auth::id(),
                'jumlah_masuk'      => $masuk,
                'jumlah_keluar'     => $keluar,
                'work_order_number' => $request->wo,
                'keterangan'        => ($keluar > 0 && !empty($request->wo))
                    ? 'Terpakai digunakan pada ' . $request->wo
                    : 'Update Stok Manual',
            ]);
        });

        return redirect()->back()->with('success', 'Stok dan riwayat transaksi berhasil dicatat!');
    }


    public function history(Request $request)
    {
        // Mulai kueri dengan memuat relasi (Eager Loading)
        $query = InventoryHistory::with(['sparepart', 'user'])->latest();

        // Logika Filter Berdasarkan Bulan (Bukan lagi per hari)
        if ($request->filled('month')) {
            // Memecah input 'YYYY-MM' menjadi array [0 => tahun, 1 => bulan]
            $monthYear = explode('-', $request->month);

            if (count($monthYear) == 2) {
                $query->whereYear('created_at', $monthYear[0])
                    ->whereMonth('created_at', $monthYear[1]);
            }
        }

        $histories = $query->paginate(10)->withQueryString();

        return view('spareparts.history', compact('histories'));
    }

    public function destroy($id)
    {
        $sparepart = Sparepart::findOrFail($id);
        $sparepart->delete();

        return redirect()->route('spareparts.index')->with('success', 'Bahan baku berhasil dihapus!');
    }
}
