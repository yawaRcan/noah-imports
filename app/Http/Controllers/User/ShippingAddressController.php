<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Models\ShippingAddress;
use App\Models\User;
use App\Http\Requests\User\ShipperAddress\StoreRequest;
use App\Http\Requests\User\ShipperAddress\UpdateRequest;

class ShippingAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shippingAddresses = ShippingAddress::whereHasMorph('morphable', [User::class])->get();
        return view('user.shipping-address.index',compact('shippingAddresses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.shipping-address.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $user = Auth::user();
        $shipping = new ShippingAddress();
        $shipping->country_id = $request->country_id; 
        $shipping->first_name = $request->first_name; 
        $shipping->last_name = $request->last_name; 
        $shipping->email = $request->email; 
        $shipping->initial_country = $request->initial_country; 
        $shipping->country_code = $request->country_code; 
        $shipping->phone = $request->phone; 
        $shipping->state = $request->state; 
        $shipping->city = $request->city; 
        $shipping->zipcode = $request->zipcode; 
        $shipping->crib = $request->crib; 
        $shipping->address = $request->address; 
        $shipping->status = 0;
        $shipping->morphable()->associate($user);
        $shipping->save(); 

        $notify = [
            'success' => "Shipper Address created successfully.",
            'redirect' => route('user.shipping-address.index'),
        ];
        return $notify;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $shippingAddress = ShippingAddress::findOrFail($id);
        return view('user.shipping-address.edit',compact('shippingAddress'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $shipping = ShippingAddress::findOrFail($id);
        $shipping->country_id = $request->country_id; 
        $shipping->first_name = $request->first_name; 
        $shipping->last_name = $request->last_name;
        $shipping->email = $request->email; 
        $shipping->initial_country = $request->initial_country; 
        $shipping->country_code = $request->country_code; 
        $shipping->phone = $request->phone; 
        $shipping->state = $request->state;
        $shipping->city = $request->city;
        $shipping->zipcode = $request->zipcode; 
        $shipping->crib = $request->crib; 
        $shipping->address = $request->address; 
        $shipping->status = 0;
        $shipping->save(); 

        $notify = [
            'success' => "Shipper Address updated successfully.",
            'redirect' => route('user.shipping-address.index'),
        ];
        return $notify;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ShippingAddress::findOrFail($id)->delete();
        $notify = ['success'=> "Shipper Address has been deleted."];  
        return $notify;
    }
}
