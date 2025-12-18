<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::all();
        return view('admin.settings', compact('paymentMethods'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        PaymentMethod::create($data);

        return redirect()->route('settings')->with('success', 'Payment Method added successfully!');
    }

    public function update(Request $request, $id)
    {
        $method = PaymentMethod::findOrFail($id);

        $method->update($request->only('name', 'description'));

        return redirect()->route('settings')->with('success', 'Payment Method updated successfully!');
    }

    public function destroy($id)
    {
        PaymentMethod::findOrFail($id)->delete();

        return redirect()->route('settings')->with('success', 'Payment Method deleted successfully!');
    }
}
