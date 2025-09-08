<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rider extends Model
{
     use HasFactory;

    protected $primaryKey = 'rider_id'; // custom primary key

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'status',
    ];

    /**
     * A rider may have many orders assigned.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'rider_id', 'rider_id');
    }
}
