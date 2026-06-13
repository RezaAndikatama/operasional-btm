<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\WorkOrderController;
use App\Http\Controllers\RekapitulasiController;
use App\Http\Controllers\SparepartController;
use App\Models\WorkOrder;
use Illuminate\Support\Facades\Route;

// Mengarahkan root domain langsung ke halaman login
Route::redirect('/', '/login');

// Rute Customer mengecek status WO (Bebas diakses tanpa login)
Route::get('/cek-status', function () {
    $wo_number = request()->query('wo_number');
    $workOrder = null;

    if ($wo_number) {
        // PERBAIKAN: Menambahkan relasi 'technician' agar nama teknisi bisa ditarik
        $workOrder = WorkOrder::with(['customer', 'technician'])
            ->where('wo_number', $wo_number)
            ->first();
    }

    return view('public.track', compact('workOrder', 'wo_number'));
})->name('cek-status');


// WAJIB LOGIN (Hanya bisa diakses jika sudah login & terverifikasi)
Route::middleware(['auth', 'verified'])->group(function () {

    // Route Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profil User (Dioptimalkan dengan Controller Grouping)
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    // 2. OPERASIONAL (Admin, Manajer, Teknisi, Karyawan)
    Route::middleware('role:admin|Admin|manajer|Manajer|teknisi|Teknisi|karyawan|Karyawan')->group(function () {

        // Work Order Custom Routes
        Route::controller(WorkOrderController::class)->group(function () {
            Route::get('/work_orders/{id}/invoice', 'invoice')->name('work_orders.invoice');
            Route::get('/work_orders/{id}/detail', 'show')->name('work_orders.show');
            Route::post('/work_orders/{id}/spareparts', 'addSparepart')->name('work_orders.add_sparepart');
            Route::delete('/work_orders/{id}/spareparts/{sparepart_id}', 'removeSparepart')->name('work_orders.remove_sparepart');
        });

        // Work Order Resource (Kecuali 'show' karena sudah di-override di atas dengan '/detail')
        Route::resource('work_orders', WorkOrderController::class)->except(['show']);

        // Rekap Transaksi
        Route::get('/rekapitulasi', [RekapitulasiController::class, 'index'])->name('rekapitulasi.index');

        // History Inventori
        Route::controller(SparepartController::class)->group(function () {
            Route::get('/spareparts/history', 'history')->name('spareparts.history');
            Route::post('/spareparts/update-stock', 'updateStock')->name('spareparts.update_stock');
        });

        // Data Inventori Utama
        Route::resource('spareparts', SparepartController::class);
    });

    // 3. MASTER DATA (Hanya Admin dan Manajer)
    Route::middleware('role:admin|Admin|manajer|Manajer')->group(function () {

        // Master Data User
        Route::controller(UserController::class)->group(function () {
            Route::get('/users', 'index')->name('users.index');
            Route::post('/users', 'store')->name('users.store');
            Route::put('/users/{id}', 'update')->name('users.update');
            Route::delete('/users/{id}', 'destroy')->name('users.destroy');
        });

        // Master Data Teknisi
        Route::controller(TechnicianController::class)->group(function () {
            Route::get('/technicians', 'index')->name('technicians.index');
            Route::post('/technicians', 'store')->name('technicians.store');
            Route::put('/technicians/{id}', 'update')->name('technicians.update');
            Route::delete('/technicians/{id}', 'destroy')->name('technicians.destroy');
        });

        // Master Data Customer
        Route::resource('customers', CustomerController::class);
    });
});

// Memanggil rute autentikasi (login, dll)
require __DIR__ . '/auth.php';
