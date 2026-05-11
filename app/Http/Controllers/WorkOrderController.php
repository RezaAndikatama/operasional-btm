<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use App\Models\Customer;
use Illuminate\Http\Request;

class WorkOrderController extends Controller
{
    // Menampilkan daftar halaman WO    
    public function index(Request $request)
    {
        // 1. Mulai Query dasar beserta relasi pelanggannya
        $query = \App\Models\WorkOrder::with('customer');

        // 2. Cek apakah ada request Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 3. Cek Urutan Waktu (Sortir)
        if ($request->sort === 'oldest') {
            $query->orderBy('created_at', 'asc'); // Terlama / Dibuat duluan
        } else {
            $query->orderBy('created_at', 'desc'); // Terbaru (Default)
        }

        // 4. Eksekusi dengan Pagination (10 data per halaman) dan bawa parameter filter
        $workOrders = $query->paginate(10)->appends($request->query());

        // 5. Mengambil data pelanggan untuk pilihan dropdown di modal Tambah WO
        $customers = \App\Models\Customer::orderBy('company_name', 'asc')->get();

        // 6. Mengirimkan kedua data tersebut ke file view index.blade.php
        return view('work_orders.index', compact('workOrders', 'customers'));
    }

    public function store(Request $request)
    {
        // Validasi Data
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'job_name'      => 'required|string|max:255',
            'description'   => 'nullable|string',
            'status'        => 'required|string',
            'total_cost'    => 'required|numeric|min:0',
            'paid_amount'   => 'required|numeric|min:0',
        ]);

        // Cari pelanggan berdasarkan nama. Jika tidak ada, buatkan otomatis!
        $customer = \App\Models\Customer::firstOrCreate(
            ['company_name' => $request->customer_name],
            ['pic_name' => '-', 'phone' => '-', 'address' => '-']
        );

        // GENERATE NOMOR WO OTOMATIS (Format: WO-TahunBulan-001)
        $datePrefix = now()->format('Ym'); // Menghasilkan format tahun & bulan, contoh: 202604
        $lastOrder = \App\Models\WorkOrder::where('wo_number', 'like', "WO-{$datePrefix}-%")->latest()->first();

        if ($lastOrder) {
            // Jika sudah ada pesanan di bulan ini, ambil 3 digit terakhir lalu tambah 1
            $lastNumber = (int) substr($lastOrder->wo_number, -3);
            $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            // Jika ini pesanan pertama di bulan ini
            $nextNumber = '001';
        }
        $woNumber = "WO-{$datePrefix}-{$nextNumber}";

        // Simpan Work Order lengkap dengan wo_number
        \App\Models\WorkOrder::create([
            'wo_number'   => $woNumber,
            'customer_id' => $customer->id,
            'job_name'    => $request->job_name,
            'description' => $request->description,
            'status'      => $request->status,
            'total_cost'  => $request->total_cost,
            'paid_amount' => $request->paid_amount,
        ]);

        return redirect()->route('work_orders.index')->with('success', 'Work Order berhasil disimpan!');
    }

    // Update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'job_name'      => 'required|string|max:255',
            'description'   => 'nullable|string',
            'status'        => 'required|string',
            'total_cost'    => 'required|numeric|min:0',
            'paid_amount'   => 'required|numeric|min:0',
        ]);

        $workOrder = \App\Models\WorkOrder::findOrFail($id);

        // Cari atau buat pelanggan baru jika nama perusahaannya diganti
        $customer = \App\Models\Customer::firstOrCreate(
            ['company_name' => $request->customer_name],
            ['pic_name' => '-', 'phone' => '-', 'address' => '-']
        );

        // Update data
        $workOrder->update([
            'customer_id' => $customer->id,
            'job_name'    => $request->job_name,
            'description' => $request->description,
            'status'      => $request->status,
            'total_cost'  => $request->total_cost,
            'paid_amount' => $request->paid_amount,
        ]);

        return redirect()->route('work_orders.index')->with('success', 'Data Work Order berhasil diperbarui!');
    }

    // Invoice
    public function invoice($id)
    {
        $workOrder = \App\Models\WorkOrder::with('customer')->findOrFail($id);
        return view('work_orders.invoice', compact('workOrder'));
    }

    /**
     * Menampilkan halaman Detail Work Order untuk mengelola Bahan Baku
     */
    public function show($id)
    {
        // Ambil data WO beserta relasi pelanggan dan sparepart yang sudah dipakai
        $workOrder = \App\Models\WorkOrder::with(['customer', 'spareparts'])->findOrFail($id);

        // Ambil semua daftar sparepart untuk ditampilkan di dropdown pilihan
        $spareparts = \App\Models\Sparepart::orderBy('name', 'asc')->get();

        return view('work_orders.show', compact('workOrder', 'spareparts'));
    }

    // Menambahkan bahan baku
    public function addSparepart(Request $request, $id)
    {
        $request->validate([
            'sparepart_id' => 'required|exists:spareparts,id',
            'quantity_used' => 'required|integer|min:1'
        ]);

        $workOrder = \App\Models\WorkOrder::findOrFail($id);

        // Cek apakah sparepart ini sudah pernah ditambahkan ke WO ini sebelumnya
        $existing = $workOrder->spareparts()->where('sparepart_id', $request->sparepart_id)->first();

        if ($existing) {
            // Jika sudah ada, tambahkan saja jumlah kuantitasnya (update pivot)
            $newQuantity = $existing->pivot->quantity_used + $request->quantity_used;
            $workOrder->spareparts()->updateExistingPivot($request->sparepart_id, ['quantity_used' => $newQuantity]);
        } else {
            // Jika belum ada, pasangkan sebagai data baru (attach)
            $workOrder->spareparts()->attach($request->sparepart_id, ['quantity_used' => $request->quantity_used]);
        }

        return redirect()->back()->with('success', 'Bahan baku berhasil ditambahkan ke pekerjaan ini.');
    }

    // Menghapus bahan baku
    public function removeSparepart($wo_id, $sparepart_id)
    {
        $workOrder = \App\Models\WorkOrder::findOrFail($wo_id);

        // Melepaskan relasi sparepart dari WO ini
        $workOrder->spareparts()->detach($sparepart_id);

        return redirect()->back()->with('success', 'Bahan baku berhasil dihapus dari pekerjaan ini.');
    }

    // Menghapus data
    public function destroy($id)
    {
        $workOrder = \App\Models\WorkOrder::findOrFail($id);
        $workOrder->delete();

        return redirect()->route('work_orders.index')
            ->with('success', 'Data Work Order berhasil dihapus!');
    }
}
