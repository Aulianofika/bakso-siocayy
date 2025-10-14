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
            // Pastikan kolom user_id ada sebelum dihapus
            if (Schema::hasColumn('orders', 'user_id')) {
                $table->dropForeign(['user_id']); // hapus foreign key dulu
                $table->dropColumn('user_id');     // hapus kolomnya
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Tambahkan kembali kolom user_id jika rollback
            if (!Schema::hasColumn('orders', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            }
        });
    }
};
