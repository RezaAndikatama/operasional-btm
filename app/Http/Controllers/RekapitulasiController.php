<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkOrder;
use Carbon\Carbon;

class RekapitulasiController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil filter bulan dari request, default ke bulan saat ini
        $filterBulan = $request->get('bulan', Carbon::now()->format('Y-m'));
        $date = Carbon::parse($filterBulan);
        $namaBulan = $date->translatedFormat('F Y');

        // 2. Buat query dasar untuk data yang sudah selesai pada bulan tersebut
        $query = WorkOrder::where('status', 'Selesai')
            ->whereYear('updated_at', $date->year)
            ->whereMonth('updated_at', $date->month);

        // 3. Hitung total pemasukan untuk bulan tersebut (keseluruhan, bukan per halaman)
        $totalPemasukan = (clone $query)->sum('total_cost');

        // 4. PERBAIKAN: Ubah ->get() menjadi ->paginate() dan urutkan dari yang terbaru
        // ->withQueryString() berfungsi menjaga parameter '?bulan=YYYY-MM' saat pindah halaman
        $transaksi = $query->latest('updated_at')
            ->paginate(5)
            ->withQueryString();

        return view('work_orders.rekapitulasi', compact(
            'transaksi',
            'totalPemasukan',
            'filterBulan',
            'namaBulan'
        ));
    }
}
