<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'profile_picture_path',
        'role',
        'gender',
        'date_of_birth',
    ];

    public function addresses()
    {
        return $this->hasMany(UserAddress::class, 'user_id', 'id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'user_id', 'id');
    }

    public function wishlistItems()
{
    return $this->hasMany(\App\Models\Wishlist::class, 'user_id', 'id');
}

public function wishlistProducts()
{
    return $this->belongsToMany(\App\Models\Product::class, 'wishlists', 'user_id', 'product_id', 'id', 'product_id');
}




    // ---------------------------
    // Custom Helper Methods
    // ---------------------------

    // Get full name
    public function getFullName(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getFullAddress(): string
    {
        // Try to get default address
        $defaultAddress = $this->addresses()->where('is_default', 1)->first();

        // Fallback: pick first address if no default
        if (!$defaultAddress) {
            $defaultAddress = $this->addresses()->first();
        }

        if ($defaultAddress) {
            return "{$defaultAddress->address}, {$defaultAddress->city}, {$defaultAddress->state} {$defaultAddress->zip_code}, {$defaultAddress->country}";
        }

        return "Address not set";
    }


    public function notifications()
{
    return $this->hasMany(Notification::class, 'user_id');
}


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date', 
        ];
    }
}
