<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // Specify the table name (optional if it matches convention)
    protected $table = 'payments';

    // Specify the primary key (optional if it’s 'id')
    protected $primaryKey = 'payment_id';

    // Mass assignable fields
    protected $fillable = [
        'order_id',
        'method',
        'status',
        'amount',
        'transaction_id',
        'paid_at',
    ];

    // Relationships
    // **Corrected Order Relationship**
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}
