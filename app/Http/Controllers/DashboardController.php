<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkOrder;
use App\Models\Sparepart;
use App\Models\Technician;
use App\Models\InventoryHistory;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Mendapatkan referensi waktu Bulan dan Tahun saat ini
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        // 1. DATA CARD UTAMA (SINKRONISASI DENGAN REKAPITULASI)
        // Kita buat kueri dasar: Hanya ambil data yang statusnya 'Selesai' di bulan ini
        $querySelesaiBulanIni = WorkOrder::where('status', 'Selesai')
            ->whereMonth('updated_at', $bulanIni)
            ->whereYear('updated_at', $tahunIni);

        // Ambil total pendapatan dari 'total_cost' (Sama persis dengan halaman Rekapitulasi)
        $totalPemasukan = (clone $querySelesaiBulanIni)->sum('total_cost');

        // Ambil jumlah pesanan selesai
        $woSelesai = (clone $querySelesaiBulanIni)->count();

        // Metrik operasional lainnya (Masih aktif / belum selesai)
        $totalWoAktif = WorkOrder::whereIn('status', ['Pending', 'Sedang Dikerjakan'])->count();
        $statusPending = WorkOrder::where('status', 'Pending')->count();
        $statusInProgress = WorkOrder::where('status', 'Sedang Dikerjakan')->count();
        $totalKaryawan = Technician::count();

        // 2. DATA PERINGATAN STOK
        $lowStockItems = Sparepart::where('stock', '<=', 5)->get();

        // 3. DATA AKTIVITAS TERBARU
        $recentActivities = InventoryHistory::with('sparepart')->latest()->take(5)->get();

        // 4. DATA TUNGGU PEKERJAAN
        $waitingList = WorkOrder::with('customer')->where('status', 'Pending')->oldest()->take(5)->get();

        // 5. DATA GRAFIK
        $months = [];
        $pemasukanData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->translatedFormat('M');

            // Grafik juga mengambil dari total_cost dan waktu penyelesaian (updated_at)
            $pemasukan = WorkOrder::where('status', 'Selesai')
                ->whereYear('updated_at', $date->year)
                ->whereMonth('updated_at', $date->month)
                ->sum('total_cost');

            $pemasukanData[] = (int) $pemasukan;
        }

        // Variabel dikirim ke View
        return view('dashboard', compact(
            'totalPemasukan',
            'totalWoAktif',
            'statusPending',
            'statusInProgress',
            'woSelesai',
            'totalKaryawan',
            'lowStockItems',
            'recentActivities',
            'waitingList',
            'months',
            'pemasukanData'
        ));
    }
}
