<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id(); // INI SANGAT PENTING (Primary Key)
            $table->string('wo_number')->unique(); // Nomor unik WO
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade'); // Relasi pelanggan

            $table->string('job_name');
            $table->text('description')->nullable();
            $table->string('status');
            $table->decimal('total_cost', 15, 2)->default(0);
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->timestamps();
        });
    }
};
