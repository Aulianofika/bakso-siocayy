<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'kode_invoice',
        'total_price',
        'status_order',
        'status_payment',
        'amount_paid',
        'tanggal_pesan',
        'tanggal_selesai',
    ];

    /**
     * Relasi ke Customer (setiap order milik satu pelanggan)
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Relasi ke Item Order
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relasi ke Pengiriman
     */
    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }
}
