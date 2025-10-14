<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockIncident extends Model
{
     use HasFactory;

    protected $fillable = [
        'product_id',
        'type',      // Retur / Reject / Hilang
        'quantity',
        'loss',      // qty × harga pokok
        'restock',   // boolean
        'note'
    ];

    // Relasi ke Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}