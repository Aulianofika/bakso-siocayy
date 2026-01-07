<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify the status_payment column to include new statuses
        DB::statement("ALTER TABLE orders MODIFY COLUMN status_payment ENUM('Belum Bayar', 'Menunggu Verifikasi', 'Lunas', 'Ditolak', 'DP') DEFAULT 'Menunggu Verifikasi'");

        // Update existing 'Belum Bayar' to 'Menunggu Verifikasi' if needed, or leave as is.
        // Also handling 'DP' removal if desired, but for data safety we keep 'DP' in ENUM but won't use it in code.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back (Optional, might fail if data exists)
        DB::statement("ALTER TABLE orders MODIFY COLUMN status_payment ENUM('Belum Bayar', 'DP', 'Lunas') DEFAULT 'Belum Bayar'");
    }
};
