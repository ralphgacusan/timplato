<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserAddress extends Model
{
    use HasFactory;

    protected $table = 'user_addresses'; // Explicitly define table

    protected $primaryKey = 'address_id'; // Custom primary key

    protected $fillable = [
        'user_id',
        'label',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'is_default',
    ];

    /**
     * A user address belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
