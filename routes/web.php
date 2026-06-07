<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\WorkOrderController;
use App\Http\Controllers\RekapitulasiController;
use App\Http\Controllers\SparepartController;
use Illuminate\Support\Facades\Route;

// Mengarahkan root domain langsung ke halaman login
Route::redirect('/', '/login');

// Rute Customer mengecek status WO (Bebas diakses tanpa login)
Route::get('/cek-status', function () {
    $wo_number = request()->query('wo_number');
    $workOrder = null;

    if ($wo_number) {
        $workOrder = \App\Models\WorkOrder::with('customer')->where('wo_number', $wo_number)->first();
    }

    return view('track', compact('workOrder', 'wo_number'));
})->name('cek-status');

//  WAJIB LOGIN (Hanya bisa diakses jika sudah login & terverifikasi)

Route::middleware(['auth', 'verified'])->group(function () {

    // Route Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profil User
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2.  OPERASIONAL (Admin dan Manajer)
    Route::group(['middleware' => ['role:admin|Admin|manajer|Manajer|teknisi|Teknisi|karyawan|Karyawan']], function () {

        // Work Order
        Route::resource('work_orders', WorkOrderController::class);
        Route::get('/work_orders/{id}/invoice', [WorkOrderController::class, 'invoice'])->name('work_orders.invoice');
        Route::get('/work_orders/{id}/detail', [WorkOrderController::class, 'show'])->name('work_orders.show');
        Route::post('/work_orders/{id}/spareparts', [WorkOrderController::class, 'addSparepart'])->name('work_orders.add_sparepart');
        Route::delete('/work_orders/{id}/spareparts/{sparepart_id}', [WorkOrderController::class, 'removeSparepart'])->name('work_orders.remove_sparepart');

        // Rekap Transaksi
        Route::get('/rekapitulasi', [RekapitulasiController::class, 'index'])->name('rekapitulasi.index');

        // History
        Route::get('/spareparts/history', [SparepartController::class, 'history'])->name('spareparts.history');
        Route::post('/spareparts/update-stock', [SparepartController::class, 'updateStock'])->name('spareparts.update_stock');

        // Data Inventori
        Route::resource('spareparts', SparepartController::class);
    });

    // 3. MASTER DATA (Admin dan Manajer)
    Route::group(['middleware' => ['role:admin|Admin|manajer|Manajer']], function () {

        // Master Data User
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        // Master Data Teknisi
        Route::get('/technicians', [TechnicianController::class, 'index'])->name('technicians.index');
        Route::post('/technicians', [TechnicianController::class, 'store'])->name('technicians.store');
        Route::put('/technicians/{id}', [TechnicianController::class, 'update'])->name('technicians.update');
        Route::delete('/technicians/{id}', [TechnicianController::class, 'destroy'])->name('technicians.destroy');

        // Master Data Customer
        Route::resource('customers', CustomerController::class);
    });
});

// Memanggil rute autentikasi (login, dll)
require __DIR__ . '/auth.php';
