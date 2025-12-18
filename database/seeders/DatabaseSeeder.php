<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NotificationSetting;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();


            NotificationSetting::insert([
        ['key' => 'placed', 'label' => 'Order Placed', 'enabled' => true],
        ['key' => 'confirmed', 'label' => 'Order Confirmed', 'enabled' => true],
        ['key' => 'processing', 'label' => 'Order Processing', 'enabled' => true],
        ['key' => 'shipped', 'label' => 'Order Shipped', 'enabled' => true],
        ['key' => 'delivered', 'label' => 'Order Delivered', 'enabled' => true],
        ['key' => 'cancelled', 'label' => 'Order Cancelled', 'enabled' => true],
        ['key' => 'refunded', 'label' => 'Order Refunded', 'enabled' => true],
        ['key' => 'voucher', 'label' => 'Voucher Created', 'enabled' => true],

    ]);
    }

    

}
