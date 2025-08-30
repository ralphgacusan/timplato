<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductImage extends Model
{
    use HasFactory;

    // Specify the primary key if not the default 'id'
    protected $primaryKey = 'image_id';

    // Allow mass assignment for these fields
    protected $fillable = [
        'product_id',
        'image_url',
        'is_primary',
    ];

    /**
     * Relationship: The product this image belongs to
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
