<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'email',
        'no_telepon',
        'alamat',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
