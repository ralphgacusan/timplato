<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;

class UserAddressController extends Controller
{

    public function showManageAddressPage()
    {
        // Get addresses for the logged-in user
        $addresses = Auth::user()->addresses()->orderBy('is_default', 'desc')->get();

        // Return view with addresses
        return view('customer.manage-address', compact('addresses'));
    }

    // Store new address
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'country' => 'required|string|max:100',
            'is_default' => 'nullable|boolean',
        ]);

        // If new address is default, reset other default addresses
        if ($request->has('is_default')) {
            UserAddress::where('user_id', Auth::id())->update(['is_default' => false]);
        }

        Auth::user()->addresses()->create([
            'label' => $request->label,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'country' => $request->country,
            'is_default' => $request->has('is_default') ? true : false,
        ]);

        return redirect()->back()->with('success', 'Address added successfully!');
    }

    // Update an existing address
    public function update(Request $request, $id)
    {
        $request->validate([
            'label' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'country' => 'required|string|max:100',
            'is_default' => 'nullable|boolean',
        ]);

        $address = UserAddress::where('user_id', Auth::id())->findOrFail($id);

        // If updated address is default, reset other default addresses
        if ($request->has('is_default')) {
            UserAddress::where('user_id', Auth::id())->update(['is_default' => false]);
        }

        $address->update([
            'label' => $request->label,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'country' => $request->country,
            'is_default' => $request->has('is_default') ? true : false,
        ]);

        return redirect()->back()->with('success', 'Address updated successfully!');
    }

    // Delete an address
    public function destroy($id)
    {
        $address = UserAddress::where('user_id', Auth::id())->findOrFail($id);
        $address->delete();

        return redirect()->back()->with('success', 'Address deleted successfully!');
    }
}
