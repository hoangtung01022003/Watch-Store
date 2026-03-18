<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Auth::user()->addresses()->latest()->get();
        return view('profile.addresses', compact('addresses'));
    }

    public function store(StoreAddressRequest $request)
    {
        $user = Auth::user();
        $isFirst = $user->addresses()->count() === 0;

        $user->addresses()->create(array_merge($request->validated(), [
            'is_default' => $isFirst
        ]));

        return back()->with('success', 'Address added successfully.');
    }

    public function update(UpdateAddressRequest $request, Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validated();
        
        if (isset($data['is_default']) && $data['is_default']) {
            Auth::user()->addresses()->update(['is_default' => false]);
            $data['is_default'] = true;
        } else {
            // Cannot un-default an address directly, so just ignore or set appropriately
            $data['is_default'] = false;
        }

        $address->update($data);

        return back()->with('success', 'Address updated successfully.');
    }

    public function destroy(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $address->delete();

        // If the deleted address was default, make the most recent one default
        if ($address->is_default) {
            $latestAddress = Auth::user()->addresses()->latest()->first();
            if ($latestAddress) {
                $latestAddress->update(['is_default' => true]);
            }
        }

        return back()->with('success', 'Address deleted successfully.');
    }

    public function setDefault(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        // Set all to false
        Auth::user()->addresses()->update(['is_default' => false]);

        // Set selected to true
        $address->update(['is_default' => true]);

        return back()->with('success', 'Default address updated.');
    }
}
