<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;

    // Izinkan kolom-kolom ini diisi melalui form (Mencegah error mass assignment)
    protected $fillable = [
        'wo_number',
        'customer_id',
        'job_name',
        'description',
        'total_cost',
        'paid_amount',
        'estimasi_selesai',
        'status',
    ];

    protected $casts = [
        'estimasti_selesai' => 'date',
    ];

    // Hubungkan otomatis ke model Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relasi ke tabel sparepart
    public function spareparts()
    {
        return $this->belongsToMany(Sparepart::class, 'sparepart_work_order')
            ->withPivot('quantity_used')
            ->withTimestamps();
    }
}
