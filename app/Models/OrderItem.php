<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
        // SoftDeletes on product will let the history be kept in orders.
        // It's possible to add `->withTrashed()` if you always want to load the product structure, e.g. `return $this->belongsTo(Product::class)->withTrashed();`
    }
}
