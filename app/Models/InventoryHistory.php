<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryHistory extends Model
{
    protected $guarded = [];

    // Tambahkan relasi ini
    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class);
    }
}
