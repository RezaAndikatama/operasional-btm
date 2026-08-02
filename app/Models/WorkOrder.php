<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;

    // TAMBAHKAN BARIS INI
    protected $primaryKey = 'work_order_id';

    // Izinkan kolom-kolom ini diisi melalui form (Mencegah error mass assignment)
    protected $fillable = [
        'wo_number',
        'customer_id',
        'technician_id',
        'job_name',
        'description',
        'total_cost',
        'paid_amount',
        'estimasi_selesai',
        'status',
    ];

    protected $casts = [
        // PERBAIKAN 1: Memperbaiki typo (sebelumnya 'estimasti_selesai')
        'estimasi_selesai' => 'date',
    ];

    public function technician()
    {
        return $this->belongsTo(Technician::class, 'technician_id', 'technician_id');
    }

    // Hubungkan otomatis ke model Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    // Relasi ke tabel sparepart
    public function spareparts()
    {
        // PERBAIKAN 2: Menegaskan parameter foreign_key untuk pivot table
        // belongsToMany(Model_Tujuan, 'nama_tabel_pivot', 'fk_tabel_ini_di_pivot', 'fk_tabel_tujuan_di_pivot')
        return $this->belongsToMany(Sparepart::class, 'sparepart_work_order', 'work_order_id', 'sparepart_id')
            ->withPivot('quantity_used')
            ->withTimestamps();
    }
}
