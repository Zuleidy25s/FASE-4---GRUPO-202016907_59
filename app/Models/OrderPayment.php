<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    protected $fillable = [
        'order_id',
        'transaction_id',
        'reference',
        'gateway',
        'receipt_path',
        'payment_data',
        'status',
        'amount',
    ];

    protected $casts = [
        'payment_data' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
