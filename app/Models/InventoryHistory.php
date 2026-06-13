<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'sparepart_id',
        'user_id',
        'jumlah_masuk',
        'jumlah_keluar',
        'work_order_number',
        'keterangan',
    ];

    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
