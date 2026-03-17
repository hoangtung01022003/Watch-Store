<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
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

    public function store(AddressRequest $request)
    {
        $user = Auth::user();
        $isFirst = $user->addresses()->count() === 0;

        $user->addresses()->create(array_merge($request->validated(), [
            'is_default' => $isFirst
        ]));

        return back()->with('success', 'Address added successfully.');
    }

    public function update(AddressRequest $request, Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $address->update($request->validated());

        return back()->with('success', 'Address updated successfully.');
    }

    public function destroy(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $address->delete();

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
