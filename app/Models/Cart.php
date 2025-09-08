<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $primaryKey = 'cart_id'; // tell Laravel the primary key

    protected $fillable = [
        'user_id',
    ];


    // A cart belongs to one user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // A cart has many cart items
    public function items()
    {
        return $this->hasMany(CartItem::class, 'cart_id', 'cart_id');
    }
}
