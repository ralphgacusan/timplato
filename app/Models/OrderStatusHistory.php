<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatusHistory extends Model
{
    use HasFactory;

    protected $primaryKey = 'history_id'; // Custom primary key
    public $timestamps = true; // Enable created_at and updated_at
    protected $table = 'order_status_history'; // match your migration

    protected $fillable = [
        'order_id',
        'status',
        'location',
    ];

    /**
     * Relationships
     */

    // Each status history belongs to an order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}
