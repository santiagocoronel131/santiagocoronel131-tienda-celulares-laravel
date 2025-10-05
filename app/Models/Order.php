<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'order_date', 'total_amount', 'status', 'address'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
