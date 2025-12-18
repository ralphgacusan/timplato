<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $table = 'vouchers';

    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'description',
    ];

    /**
     * Calculate discount amount based on subtotal and shipping.
     */
    public function calculateDiscount(float $subtotal, float $shippingCost): float
    {
        if ($this->discount_type === 'fixed') {
            return $this->discount_value;
        }

        if ($this->discount_type === 'percentage') {
            return ($subtotal + $shippingCost) * $this->discount_value;
        }

        return 0;
    }
}
