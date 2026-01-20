<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add 'Menunggu Pembatalan' to status_order enum
        DB::statement("ALTER TABLE orders MODIFY COLUMN status_order ENUM('Pending', 'Diproses', 'Siap Dikirim', 'Selesai', 'Ditolak', 'Menunggu Pembatalan') DEFAULT 'Pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert enum
        DB::statement("ALTER TABLE orders MODIFY COLUMN status_order ENUM('Pending', 'Diproses', 'Siap Dikirim', 'Selesai', 'Ditolak') DEFAULT 'Pending'");
    }
}; 
