<?php

namespace App\Http\Controllers\Admin;

use App\Models\Branch;

use App\Models\Country;

use App\Models\Currency;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\Branch\StoreRequest;

use App\Http\Requests\Admin\Branch\UpdateRequest;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) 
    {
        if($request->ajax())
        { 

         $Branch = Branch::with('currency')->paginate(2);

         return view('admin.branch.list',['Branch' => $Branch]);

        }else{

         $Branch = Branch::with('currency')->paginate(2); 

         return view('admin.branch.index',['Branch' => $Branch]);

        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $currency = Currency::all();

        return view('admin.branch.add',['currency'=>$currency]);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    { 
        $Branch = new Branch();

        $Branch->name = $request->name;

        $Branch->last_name = $request->last_name;

        $Branch->branch_key = (float) substr(str_shuffle(23456789), -1) . substr(strtotime('now'), -3);

        $countryName  = Country::where('id',$request->country)->pluck('name')->first();

        $Branch->country = $countryName;

        $Branch->zipcode = $request->zipcode;

        $Branch->country_id = $request->country;

        $Branch->state = $request->state;

        $Branch->city = $request->city;

        $Branch->address = $request->address;

        $Branch->address_line = $request->address_line;

        $Branch->email = $request->email;

        if($request->phone_complete == '' || $request->phone_complete == null){

            $Branch->initial_country = null;

            $Branch->country_code = null;

        }else{
            
            $Branch->phone = $request->phone_complete; 

            $Branch->initial_country = $request->initial_country;

            $Branch->country_code = $request->country_code;

        }

        $Branch->currency_id = $request->currency_id;  

        $Branch->pickup_fee = $request->pickup_fee;

        $Branch->save();

        $notify = ['success'=> "Branch has been added."];
    	return $notify;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {  

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $currency = Currency::all(); 

        $Branch = Branch::findOrFail($id); 

        return view('admin.branch.edit',['Branch' => $Branch,'currency'=>$currency]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    { 
        $Branch = Branch::findOrFail($id);

        $Branch->name = $request->name;

        $Branch->last_name = $request->last_name;
        
        $Branch->zipcode = $request->zipcode; 

        $countryName  = Country::where('id',$request->country)->pluck('name')->first();

        $Branch->country = $countryName;

        $Branch->country_id = $request->country;

        $Branch->state = $request->state;

        $Branch->city = $request->city;

        $Branch->address = $request->address;

        $Branch->address_line = $request->address_line;

        $Branch->email = $request->email;

        if($request->phone_complete == '' || $request->phone_complete == null){

            $Branch->initial_country = null;

            $Branch->country_code = null;

        }else{

            $Branch->phone = $request->phone_complete; 

            $Branch->initial_country = $request->initial_country;

            $Branch->country_code = $request->country_code;

        }

        $Branch->currency_id = $request->currency_id;  

        $Branch->pickup_fee = $request->pickup_fee;

        $Branch->save(); 

        $notify = ['success'=> "Branch has been updated."];

    	return $notify;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        Branch::findOrFail($id)->delete();
        
        $notify = ['success'=> "Branch has been deleted."];

    	return $notify;
    }
     
}
