<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\User;

use App\Models\NotificationSetting;
use App\Models\Notification;


class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::all();
        return view('admin.settings', compact('vouchers'));
    }

   public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|unique:vouchers,code',
            'discount_type' => 'required|in:fixed,percentage',
            'discount_value' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        // Convert percentage input (e.g. 50) into decimal (0.5)
        if ($data['discount_type'] === 'percentage') {
            $data['discount_value'] = $data['discount_value'] / 100;
        }

        $voucher = Voucher::create($data);

        // ✅ Send voucher notification if enabled
        $this->sendVoucherNotification($voucher);

        return redirect()->route('settings')->with('success', 'Voucher added successfully!');
    }

public function update(Request $request, $id)
{
    $voucher = Voucher::findOrFail($id);

    $data = $request->validate([
        'code' => 'required|unique:vouchers,code,' . $voucher->id,
        'discount_type' => 'required|in:fixed,percentage',
        'discount_value' => 'required|numeric|min:0',
        'description' => 'nullable|string',
    ]);

    // ✅ Convert percentage input (e.g. 50) into decimal (0.5)
    if ($data['discount_type'] === 'percentage') {
        $data['discount_value'] = $data['discount_value'] / 100;
    }

    $voucher->update($data);

    return redirect()->route('settings')->with('success', 'Voucher updated successfully!');
}


    public function destroy($id)
    {
        Voucher::findOrFail($id)->delete();

        return redirect()->route('settings')->with('success', 'Voucher deleted successfully!');
    }

   public function validateVoucher(Request $request)
{
    $code = strtoupper($request->query('code', ''));
    $subtotal = (float) $request->query('subtotal', 0);
    $shipping = (float) $request->query('shipping', 0);

    if (! $code) {
        return response()->json(['valid' => false, 'message' => 'Please provide a code.']);
    }

    $voucher = Voucher::where('code', $code)->first();

    if (! $voucher) {
        return response()->json(['valid' => false, 'message' => 'Invalid voucher code.']);
    }

    $discount = $voucher->calculateDiscount($subtotal, $shipping);

    return response()->json([
        'valid' => true,
        'code' => $voucher->code,
        'discount' => $discount,
        'description' => $voucher->description,
        'type' => $voucher->discount_type,
        'value' => $voucher->discount_value,
    ]);
}



   // --------------------------
    // New private helper method
    // --------------------------
    private function sendVoucherNotification(Voucher $voucher)
{
    $setting = NotificationSetting::where('key', 'voucher')->first();

    if ($setting && !$setting->enabled) {
        return; // Do not send if disabled
    }

    $users = User::all();

    foreach ($users as $user) {
        // Build a concise, informative message
        $discountText = $voucher->discount_type === 'percentage'
            ? ($voucher->discount_value * 100) . '% off'
            : '₱' . number_format($voucher->discount_value, 2) . ' off';

        $message = "New voucher <b>{$voucher->code}</b> available: {$discountText}. {$voucher->description}";

        Notification::create([
            'user_id' => $user->id,
            'order_id' => null,
            'title' => 'New Voucher Available!',
            'message' => $message,
            'read_status' => false,
        ]);
    }
}


}
