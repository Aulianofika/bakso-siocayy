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
        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_id')->constrained('shipments')->cascadeOnDelete(); // relasi ke pengiriman
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete(); // relasi ke produk
            $table->integer('quantity')->default(1);
            $table->string('reason')->nullable(); // alasan retur pelanggan
            $table->boolean('restock')->default(false); // jika true → stok produk bertambah
            $table->decimal('loss', 12, 2)->default(0); // nilai kerugian
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};
