<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryMethod;

class DeliveryMethodController extends Controller
{
    public function index()
    {
        $deliveryMethods = DeliveryMethod::all();
        return view('admin.settings', compact('deliveryMethods'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'fee' => 'required|numeric|min:0',
            'description' => 'nullable',
        ]);

        DeliveryMethod::create($data);

        return redirect()->route('settings')->with('success', 'Delivery Method added successfully!');
    }

    public function update(Request $request, $id)
    {
        $method = DeliveryMethod::findOrFail($id);

        $method->update($request->only('name', 'fee', 'description'));

        return redirect()->route('settings')->with('success', 'Delivery Method updated successfully!');
    }

    public function destroy($id)
    {
        DeliveryMethod::findOrFail($id)->delete();

        return redirect()->route('settings')->with('success', 'Delivery Method deleted successfully!');
    }
}
