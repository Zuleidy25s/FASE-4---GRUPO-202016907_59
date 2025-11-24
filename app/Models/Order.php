<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'type',
        'customer_name',
        'customer_phone',
        'customer_email',
        'payment_method',
        'payment_status',
        'status',
        'qr_path',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function orderItems()
    {
        return $this->hasMany(\App\Models\OrderItem::class);
    }

    public function orderPayments()
    {
        return $this->hasMany(\App\Models\OrderPayment::class);
    }

    public function payment()
    {
        return $this->hasOne(OrderPayment::class);
    }

}
