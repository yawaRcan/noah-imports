<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\ShipmentMode;

use App\Http\Requests\Admin\ShipmentMode\StoreRequest;

use App\Http\Requests\Admin\ShipmentMode\UpdateRequest;

use Yajra\DataTables\Facades\DataTables;

class ShipmentModeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shipMentMode = ShipmentMode::paginate(10);
        return view('admin.shipment-mode.index', ['shipMentMode' => $shipMentMode]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.shipment-mode.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $shipMentMode = new ShipmentMode;
        $shipMentMode->name = $request->name;
        $shipMentMode->save();
        $notify = ['success' => "Shipment Mode has been added."];

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
        $shipMentMode = ShipmentMode::findOrFail($id);
        return view('admin.shipment-mode.edit', ['shipMentMode' => $shipMentMode]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $shipMentMode = ShipmentMode::findOrFail($id);
        $shipMentMode->name = $request->name;
        $shipMentMode->save();
        $notify = ['success' => "Shipment Mode has been updated."];
        return $notify;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ShipmentMode::findOrFail($id)->delete();
        $notify = ['success' => "Shipment Mode has been deleted."];

        return $notify;
    }

    public function data(Request $var = null)
    {
        $data = ShipmentMode::get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="dropdown dropstart">
                    <a href="#" class="link" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal feather-sm">
                            <circle cx="12" cy="12" r="1"></circle>
                            <circle cx="19" cy="12" r="1"></circle>
                            <circle cx="5" cy="12" r="1"></circle>
                        </svg>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="margin: 0px;">
                        <li><a class="dropdown-item shipmode-data-edit" href="#" data-shipmode-id=' . $row->id . '>Edit</a></li>
                        <li><a class="dropdown-item shipmode-data-delete" href="#" data-shipmode-id=' . $row->id . '>Delete</a></li>
                    </ul>
                </div>';
                return $actionBtn;
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at;
            })
            ->addColumn('name', function ($row) {
                return $row->name;
            })
            ->rawColumns(['action', 'created_at', 'name'])
            ->make(true);
    }
}
