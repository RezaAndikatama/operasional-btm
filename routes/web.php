<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\WorkOrderController;
use App\Http\Controllers\SparepartController;
use Illuminate\Support\Facades\Route;

// Mengarahkan root domain langsung ke halaman login
Route::redirect('/', '/login');

// Grup Rute Operasional (Hanya bisa diakses jika sudah login & terverifikasi)
Route::middleware(['auth', 'verified'])->group(function () {

    // Rute Dashboard (Terhubung dengan Data Riil)
    Route::get('/dashboard', function () {

        // 1. Mengambil Data Work Order
        $woActive = \App\Models\WorkOrder::whereIn('status', ['Sedang Dikerjakan', 'Pending', 'Menunggu'])->count();
        $statusPending = \App\Models\WorkOrder::whereIn('status', ['Pending', 'Menunggu'])->count();
        $statusInProgress = \App\Models\WorkOrder::where('status', 'Sedang Dikerjakan')->count();

        // TAMBAHAN BARU: Menghitung Total Karyawan/Teknisi
        $totalKaryawan = \App\Models\Technician::count();

        $waitingList = \App\Models\WorkOrder::with('customer')
            ->whereIn('status', ['Pending', 'Menunggu']) // (Note: saya sekalian perbaiki typo 'Menuggu' jadi 'Menunggu' ya)
            ->latest()
            ->take(5)
            ->get();

        // Menghitung Total WO Selesai
        $woSelesai = \App\Models\WorkOrder::where('status', 'Selesai')->count();

        // 2. Mengambil Data Peringatan Stok Rendah (Stok di bawah 10)
        $lowStockItems = \App\Models\Sparepart::where('stock', '<', 10)
            ->orderBy('stock', 'asc')
            ->take(4)
            ->get();

        // Mengirim data ke tampilan dashboard
        return view('dashboard', compact(
            'woActive',
            'statusPending',
            'statusInProgress',
            'totalKaryawan',
            'woSelesai',
            'waitingList',
            'lowStockItems'
        ));
    })->middleware(['auth', 'verified'])->name('dashboard');

    // Rute Master Data Teknisi
    Route::get('/technicians', [TechnicianController::class, 'index'])->name('technicians.index');
    Route::post('/technicians', [TechnicianController::class, 'store'])->name('technicians.store');
    Route::put('/technicians/{id}', [TechnicianController::class, 'update'])->name('technicians.update');
    Route::delete('/technicians/{id}', [TechnicianController::class, 'destroy'])->name('technicians.destroy');

    // Rute Master Data Customer untuk CRUD
    Route::resource('customers', CustomerController::class);

    // Work Order
    Route::resource('work_orders', WorkOrderController::class);

    // Rute Data Inventori
    Route::resource('spareparts', SparepartController::class);
});

// Grup Rute Profil bawaan Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rute Master Data User
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

// Rute custom Work Order
Route::get('/work_orders/{id}/invoice', [App\Http\Controllers\WorkOrderController::class, 'invoice'])->name('work_orders.invoice');
Route::get('/work_orders/{id}/detail', [App\Http\Controllers\WorkOrderController::class, 'show'])->name('work_orders.show');
Route::post('/work_orders/{id}/spareparts', [App\Http\Controllers\WorkOrderController::class, 'addSparepart'])->name('work_orders.add_sparepart');
Route::delete('/work_orders/{id}/spareparts/{sparepart_id}', [App\Http\Controllers\WorkOrderController::class, 'removeSparepart'])->name('work_orders.remove_sparepart');


// Rute Customer mengecek status WO
Route::get('/cek-status', function () {
    $wo_number = request()->query('wo_number');
    $workOrder = null;

    // Jika customer memasukkan nomor WO, cari di database
    if ($wo_number) {
        $workOrder = \App\Models\WorkOrder::with('customer')->where('wo_number', $wo_number)->first();
    }

    return view('track', compact('workOrder', 'wo_number'));
})->name('cek-status');

// Memanggil rute autentikasi (login, dll)
require __DIR__ . '/auth.php';
