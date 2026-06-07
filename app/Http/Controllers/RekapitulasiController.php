<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RekapitulasiController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil input bulan dari user (Format: YYYY-MM). Jika kosong, set ke bulan ini.
        $filterBulan = $request->get('bulan', Carbon::now()->format('Y-m'));

        // 2. Pecah string 'YYYY-MM' menjadi variabel tahun dan bulan terpisah
        $tahun = date('Y', strtotime($filterBulan));
        $bulan = date('m', strtotime($filterBulan));

        // 3. Query ambil data 'Selesai' yang cocok dengan bulan dan tahun tersebut
        $transaksi = WorkOrder::where('status', 'Selesai')
            ->whereMonth('updated_at', $bulan)
            ->whereYear('updated_at', $tahun)
            ->latest('updated_at')
            ->get();

        // 4. Hitung total uang masuk
        $totalPemasukan = $transaksi->sum('total_cost');

        // 5. Ubah angka bulan menjadi Teks Bahasa Indonesia (misal: "Juni 2026")
        $namaBulan = Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y');

        // 6. Kirim semua variabel ke tampilan
        return view('work_orders.rekapitulasi', compact('transaksi', 'totalPemasukan', 'filterBulan', 'namaBulan'));
    }
}
