<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id','product_id','quantity','price'];


    // Define inverse relationship with Order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // Relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
