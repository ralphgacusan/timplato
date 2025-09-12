<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $table = 'wishlists'; // Explicitly define table

    protected $primaryKey = 'wishlist_id'; // Custom PK

    protected $fillable = [
        'user_id',
        'product_id',
    ];

    /**
     * A wishlist belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * A wishlist belongs to a product
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    
}
