<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use SoftDeletes; // wajib ini

    protected $table = 'products';

    protected $fillable = [
        'seller_id',
        'name',
        'description',
        'price',
        'stock',
        'category_id',
        'image'
    ];

    function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    protected static function booted()
    {
        static::updated(function (self $product) {
            if (! $product->wasChanged('image')) {
                return;
            }

            $oldImage = $product->getOriginal('image');

            if ($oldImage && $oldImage !== $product->image && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
        });

        static::deleting(function (self $product) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
        });
    }
}
