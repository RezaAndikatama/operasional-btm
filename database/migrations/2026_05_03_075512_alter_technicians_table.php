<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('technicians', function (Blueprint $table) {
            // Mengecek apakah kolom spesialisasi ada sebelum dihapus
            if (Schema::hasColumn('technicians', 'spesialisasi')) {
                $table->dropColumn('spesialisasi');
            }

            // Mengecek dan menambahkan kolom tempat_tinggal jika belum ada
            if (!Schema::hasColumn('technicians', 'tempat_tinggal')) {
                $table->string('tempat_tinggal')->nullable()->after('name');
            }

            // Mengecek dan menambahkan kolom umur jika belum ada
            if (!Schema::hasColumn('technicians', 'umur')) {
                $table->integer('umur')->nullable()->after('tempat_tinggal');
            }
        });
    }

    public function down()
    {
        Schema::table('technicians', function (Blueprint $table) {
            if (Schema::hasColumn('technicians', 'tempat_tinggal')) {
                $table->dropColumn('tempat_tinggal');
            }
            if (Schema::hasColumn('technicians', 'umur')) {
                $table->dropColumn('umur');
            }
        });
    }
};
