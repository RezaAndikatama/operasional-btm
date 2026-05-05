<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'pic_name',
        'phone',
        'email',
        'address',
    ];

    // Tambahkan fungsi ini di dalam class Customer
    public function workOrders()
    {
        return $this->hasMany(WorkOrder::class);
    }
}
