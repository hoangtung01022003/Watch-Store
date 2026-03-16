<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSpec extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'case_size',
        'water_resistance',
        'strap_material',
        'movement',
        'glass_type',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
