<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'brand_id',
        'price',
        'stock',
        'description',
        'image',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function specs()
    {
        return $this->hasOne(ProductSpec::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        });

        $query->when(isset($filters['category_id']), function ($query) use ($filters) {
            $categoryIds = array_filter((array) $filters['category_id']);
            if (!empty($categoryIds)) {
                $query->whereIn('category_id', $categoryIds);
            }
        });

        $query->when(isset($filters['brand_id']), function ($query) use ($filters) {
            $brandIds = array_filter((array) $filters['brand_id']);
            if (!empty($brandIds)) {
                $query->whereIn('brand_id', $brandIds);
            }
        });

        if (isset($filters['min_price']) && isset($filters['max_price'])) {
            $min = (float) $filters['min_price'];
            $max = (float) $filters['max_price'];
            if ($min <= $max) {
                 $query->whereBetween('price', [$min, $max]);
            }
        } else {
            $query->when($filters['min_price'] ?? false, function ($query, $minPrice) {
                $query->where('price', '>=', (float) $minPrice);
            });
            $query->when($filters['max_price'] ?? false, function ($query, $maxPrice) {
                $query->where('price', '<=', (float) $maxPrice);
            });
        }
    }
}
