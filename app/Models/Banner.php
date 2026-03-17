<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image_url',
        'link_url',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($banner) {
            DB::transaction(function () use ($banner) {
                $maxSortOrder = static::max('sort_order') ?? 0;
                
                if (is_null($banner->sort_order)) {
                    $banner->sort_order = $maxSortOrder + 1;
                } else {
                    $banner->sort_order = max(1, min($banner->sort_order, $maxSortOrder + 1));
                    
                    static::where('sort_order', '>=', $banner->sort_order)
                        ->increment('sort_order');
                }
            });
        });

        static::updating(function ($banner) {
            if ($banner->isDirty('sort_order')) {
                DB::transaction(function () use ($banner) {
                    $oldSortOrder = $banner->getOriginal('sort_order');
                    $maxSortOrder = static::max('sort_order');
                    
                    $newSortOrder = max(1, min($banner->sort_order, $maxSortOrder));
                    $banner->sort_order = $newSortOrder;

                    if ($oldSortOrder < $newSortOrder) {
                        static::whereBetween('sort_order', [$oldSortOrder + 1, $newSortOrder])
                            ->where('id', '!=', $banner->id)
                            ->decrement('sort_order');
                    } elseif ($oldSortOrder > $newSortOrder) {
                        static::whereBetween('sort_order', [$newSortOrder, $oldSortOrder - 1])
                            ->where('id', '!=', $banner->id)
                            ->increment('sort_order');
                    }
                });
            }
        });

        static::deleted(function ($banner) {
            DB::transaction(function () use ($banner) {
                static::where('sort_order', '>', $banner->sort_order)
                    ->decrement('sort_order');
            });
        });
    }

    public static function reindexSortOrders()
    {
        DB::transaction(function () {
            $banners = static::orderBy('sort_order')->orderBy('id')->get();
            $order = 1;
            foreach ($banners as $banner) {
                if ($banner->sort_order != $order) {
                    static::where('id', $banner->id)->update(['sort_order' => $order]);
                }
                $order++;
            }
        });
    }
}
