<?php

namespace App\Exports;

use App\Models\WorkOrder; // Pastikan ini sesuai dengan nama Model transaksi Anda
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TransaksiExport implements FromView, ShouldAutoSize
{
    protected $bulan;
    protected $tahun;

    // Menangkap input bulan dan tahun dari Controller
    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        // Mengambil data Work Order yang sudah "Selesai" pada bulan & tahun terpilih
        $dataTransaksi = WorkOrder::whereMonth('created_at', $this->bulan)
            ->whereYear('created_at', $this->tahun)
            ->where('status', 'Selesai')
            ->get();

        return view('exports.transaksi_excel', [
            'transaksi' => $dataTransaksi,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun
        ]);
    }
}
