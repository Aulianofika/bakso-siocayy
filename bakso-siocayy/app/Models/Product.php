<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['category_id', 'name', 'price_sale', 'price_cost', 'stock', 'image'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function stockIncidents()
    {
        return $this->hasMany(StockIncident::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

}
