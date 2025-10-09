<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'stock',
        'discount',
    ];

    // Relasi ke TransactionItem (1 produk bisa ada di banyak transaksi)
    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'transaction_items')
                    ->withPivot(['quantity', 'price', 'subtotal'])
                    ->withTimestamps();
    }
}
