<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('payment_verified_at')->nullable()->after('status_payment');
        });

        // Seed existing 'Lunas' orders
        \App\Models\Order::where('status_payment', 'Lunas')->update([
            'payment_verified_at' => \Illuminate\Support\Facades\DB::raw('created_at')
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('payment_verified_at');
        });
    }
};
