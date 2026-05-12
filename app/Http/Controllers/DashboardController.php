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
        // 1. DATA CARD UTAMA
        $totalPemasukan = WorkOrder::sum('paid_amount');
        $totalWoAktif = WorkOrder::whereIn('status', ['Pending', 'Sedang Dikerjakan'])->count();

        $statusPending = WorkOrder::where('status', 'Pending')->count();
        $statusInProgress = WorkOrder::where('status', 'Sedang Dikerjakan')->count();
        $woSelesai = WorkOrder::where('status', 'Selesai')->count();
        $totalKaryawan = Technician::count();

        // 2. DATA PERINGATAN STOK
        $lowStockItems = Sparepart::where('stock', '<=', 5)->get();

        // 3. DATA AKTIVITAS TERBARU
        $recentActivities = InventoryHistory::with('sparepart')->latest()->take(5)->get();

        // 4. DATA TUNGGU PEKERJAAN
        $waitingList = WorkOrder::with('customer')->where('status', 'Pending')->oldest()->take(5)->get();

        // 5. DATA GRAFIK (HANYA PEMASUKAN - 6 Bulan Terakhir)
        $months = [];
        $pemasukanData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->translatedFormat('M');

            $pemasukan = WorkOrder::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('paid_amount');

            $pemasukanData[] = (int) $pemasukan;
        }

        // Variabel dikirim ke View (Tidak ada lagi pengeluaranData)
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
