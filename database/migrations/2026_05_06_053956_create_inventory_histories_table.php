<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_histories', function (Blueprint $table) {
            $table->id();
            // Hubungkan ke tabel spareparts (sesuaikan nama tabel jika berbeda)
            $table->foreignId('sparepart_id')->constrained('spareparts')->onDelete('cascade');
            $table->integer('jumlah_masuk')->default(0)->nullable();
            $table->integer('jumlah_keluar')->default(0)->nullable();
            $table->string('work_order_number')->nullable(); // Untuk menyimpan "WO-001"
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }
};
