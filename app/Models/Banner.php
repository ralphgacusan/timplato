<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'page_id', 'title', 'image', 'link', 'section', 'order', 'active'];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
