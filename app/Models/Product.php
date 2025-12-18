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
        'sold',
        'category_id',
        'status',
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

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'product_id');
    }

    
    // notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'product_id', 'product_id');
    }

    

    // Category and Subcategory

    public function getMainCategoryAttribute()
    {
        if (!$this->category) {
            return 'Uncategorized';
        }
        return $this->category->parent ? $this->category->parent->name : $this->category->name;
    }

    public function getSubCategoryAttribute()
    {
        if ($this->category && $this->category->parent) {
            return $this->category->name;
        }
        return 'N/A';
    }

    // Inventory
    public function orderItems()
    {
        return $this->hasMany(\App\Models\OrderItem::class, 'product_id', 'product_id');
    }
    
    public function getReservedStockAttribute()
    {
        return $this->orderItems()
            ->whereHas('order', function($q) {
                $q->where('current_status', 'pending');
            })
            ->sum('quantity');
    }



    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class, 'product_id', 'product_id');
    }

    public function latestStockTransaction()
    {
        return $this->hasOne(StockTransaction::class, 'product_id', 'product_id')->latest('created_at');
    }

}
