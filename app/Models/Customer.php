<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // TAMBAHKAN BARIS INI
    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'company_name',
        'pic_name',
        'phone',
        'email',
        'address',
    ];

    // Fungsi relasi ini tetap aman dan tidak perlu diubah.
    public function workOrders()
    {
        return $this->hasMany(WorkOrder::class);
    }
}
