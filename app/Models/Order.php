<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id'; // Custom primary key

    protected $fillable = [
    'user_id',
    'rider_id',
    'courier_id',
    'total_amount',
    'current_status',
    'payment_method',
    'tracking_number',
    'discount_amount',       // new
    'voucher_code',   // new
];

    /**
     * Relationships
     */

    // An order belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // An order may have a rider
    public function rider()
    {
        return $this->belongsTo(Rider::class, 'rider_id', 'rider_id');
    }

    // An order may have a courier
    public function courier()
    {
        return $this->belongsTo(Courier::class, 'courier_id', 'courier_id');
    }

    // An order has many order items
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }

    // An order has many status history records
    public function statusHistory()
    {
        return $this->hasMany(OrderStatusHistory::class, 'order_id', 'order_id');
    }

    // In Order.php
public function notifications()
{
    return $this->hasMany(Notification::class, 'order_id', 'order_id');
}



}
