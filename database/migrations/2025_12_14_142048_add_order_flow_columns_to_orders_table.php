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
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status_order', [
                'Pending',
                'Diproses',
                'Siap Dikirim',
                'Selesai',
                'Ditolak'
            ])->default('Pending')->change();

            $table->enum('status_payment', [
                'Belum Bayar',
                'DP',
                'Lunas'
            ])->default('Belum Bayar')->change();

            $table->boolean('stock_reduced')->default(false);
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'stock_reduced',
                'processed_at',
                'completed_at'
            ]);
        });
    }

};
