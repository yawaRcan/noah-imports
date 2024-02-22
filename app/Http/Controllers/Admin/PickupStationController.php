<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PickupStation;
use App\Models\Branch;
use App\Http\Requests\Admin\PickupStation\StoreRequest;
use App\Http\Requests\Admin\PickupStation\UpdateRequest;

class PickupStationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pickup-stations.index');
    }

    public function getBranchWisePickupStations(Request $request)
    {
        $stations = PickupStation::where('branch_id',$request->branch_id)->get();
        return response()->json($stations);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pickup-stations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        PickupStation::create($request->all());
        $notify = [
            'success' => "Pickup station created successfully.",
            'redirect' => route('pickup-station.index'),
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
        $station = PickupStation::findOrFail($id);
        return view('admin.pickup-stations.edit',compact('station'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {

        PickupStation::updateOrCreate(['id' => $id],$request->all());
        $notify = [
            'success' => "Pickup station updated successfully.",
            'redirect' => route('pickup-station.index'),
        ];
        return $notify;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        PickupStation::findOrFail($id)->delete();
        $notify = ['success'=> "Pickup Station has been deleted."];  
        return $notify;
    }
}
