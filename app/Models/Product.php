<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    // Specify the primary key if not the default 'id'
    protected $primaryKey = 'product_id'; // default is 'id', but your table uses 'product_id'
    // Allow mass assignment for these fields
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock_quantity',
        'restock_level',
        'category_id',
    ];

    /**
     * Relationship: The category this product belongs to
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    /**
     * Relationship: Images of this product
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'product_id');
    }

    /**
     * Optional: The primary image of this product
     */
    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class, 'product_id', 'product_id')->where('is_primary', true);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'product_id', 'product_id');
    }

}
