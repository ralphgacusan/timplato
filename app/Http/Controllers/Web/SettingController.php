<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\PaymentMethod;
use App\Models\DeliveryMethod;
use App\Models\Voucher; // ✅ import Voucher model

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        $paymentMethods = PaymentMethod::all();
        $deliveryMethods = DeliveryMethod::all();
        $vouchers = Voucher::all(); // ✅ include vouchers

        return view('admin.settings', compact('settings', 'paymentMethods', 'deliveryMethods', 'vouchers'));
    }

    public function update(Request $request)
    {
        $data = $request->only(['currency', 'store_email']);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('success', 'Settings updated successfully!');
    }
}
