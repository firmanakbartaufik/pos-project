<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'total',
        'payment_method',
    ];

    // Relasi ke TransactionItem (1 transaksi punya banyak item)
    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'transaction_items')
                    ->withPivot(['quantity', 'price', 'subtotal'])
                    ->withTimestamps();
    }

    // Format tanggal otomatis
    protected $casts = [
        'created_at' => 'datetime',
    ];
}
