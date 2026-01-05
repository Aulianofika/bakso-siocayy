<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'invoice_number',
        'total_price',
        'status_order',
        'status_payment',
        'payment_method',
        'amount_paid',
        'nama_penerima',
        'telepon',
        'alamat_lengkap',
        'catatan',
        'rekening_tujuan',
        'bukti_transfer',
    ];

    protected static function boot()
    {
        parent::boot();

        // Generate invoice otomatis saat create
        static::creating(function ($order) {
            if (empty($order->invoice_number)) {
                $order->invoice_number = 'INV-' . strtoupper(Str::random(8));
            }
        });
    }
    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Item Order
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function items()
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
