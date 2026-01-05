<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('nama_penerima')->nullable();
            $table->string('telepon')->nullable();
            $table->text('alamat_lengkap')->nullable();
            $table->text('catatan')->nullable();
            $table->string('rekening_tujuan')->nullable();
            $table->string('bukti_transfer')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'nama_penerima',
                'telepon',
                'alamat_lengkap',
                'catatan',
                'rekening_tujuan',
                'bukti_transfer'
            ]);
        });
    }
};
