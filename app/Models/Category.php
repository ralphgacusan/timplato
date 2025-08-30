<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    // Specify the primary key if not the default 'id'
    protected $primaryKey = 'category_id';

    // Allow mass assignment for these fields
    protected $fillable = [
        'name',
        'parent_id',
    ];

    /**
     * Self-referencing relationship: parent category
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'category_id');
    }

    /**
     * Self-referencing relationship: child categories
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'category_id');
    }

    /**
     * Optional: Products under this category
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'category_id');
    }
}
