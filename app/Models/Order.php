<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'seller_id',
        'customer_id',
        'order_code',
        'total_price',
        'payment_method',
        'paid_amount',
        'status',
        'resi',
        'expedition'
    ];

    /* relasi customer */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /* relasi seller */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /* relasi items */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /* generate order code otomatis */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {

            $order->order_code =
                'ORD-' . date('Ymd') . '-' . rand(1000,9999);

        });
    }
}