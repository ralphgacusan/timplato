<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    use HasFactory;

    protected $primaryKey = 'courier_id'; // custom primary key

    protected $fillable = [
        'name',
        'phone',
        'tracking_url',
    ];

    /**
     * A courier can handle many orders.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'courier_id', 'courier_id');
    }
}
