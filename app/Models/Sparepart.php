<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi
    protected $fillable = [
        'name',
        'stock',
        'price',
        'unit',
    ];

    // Relasi balik ke Work Order (Many-to-Many)
    public function workOrders()
    {
        return $this->belongsToMany(WorkOrder::class, 'sparepart_work_order')
            ->withPivot('quantity_used')
            ->withTimestamps();
    }
}
