<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'title', 'content', 'section', 'order'];

    public function banners()
    {
        return $this->hasMany(Banner::class)->orderBy('order');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}

