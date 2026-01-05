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
        Schema::table('shipments', function (Blueprint $table) {
            $table->enum('status', [
                'Menunggu',
                'Dikirim',
                'Diterima'
            ])->default('Menunggu');

            $table->timestamp('dikirim_at')->nullable();
            $table->timestamp('diterima_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'dikirim_at',
                'diterima_at'
            ]);
        });
    }
};
