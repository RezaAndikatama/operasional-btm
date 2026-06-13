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
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        $querySelesaiBulanIni = WorkOrder::where('status', 'Selesai')
            ->whereMonth('updated_at', $bulanIni)
            ->whereYear('updated_at', $tahunIni);

        $totalPemasukan = (clone $querySelesaiBulanIni)->sum('total_cost');
        $woSelesai = (clone $querySelesaiBulanIni)->count();

        $totalWoAktif = WorkOrder::whereIn('status', ['Pending', 'Sedang Dikerjakan'])->count();
        $statusPending = WorkOrder::where('status', 'Pending')->count();
        $statusInProgress = WorkOrder::where('status', 'Sedang Dikerjakan')->count();
        $totalKaryawan = Technician::count();

        $lowStockItems = Sparepart::where('stock', '<=', 5)->get();

        $recentActivities = InventoryHistory::with(['sparepart', 'user'])
            ->latest()
            ->take(5)
            ->get();

        $waitingList = WorkOrder::with('customer')
            ->where('status', 'Pending')
            ->oldest()
            ->take(5)
            ->get();

        $months = [];
        $pemasukanData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->translatedFormat('M');

            $pemasukan = WorkOrder::where('status', 'Selesai')
                ->whereYear('updated_at', $date->year)
                ->whereMonth('updated_at', $date->month)
                ->sum('total_cost');

            $pemasukanData[] = (int) $pemasukan;
        }

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
