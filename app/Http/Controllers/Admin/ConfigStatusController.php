<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\ConfigStatus;

use App\Http\Requests\Admin\ConfigStatus\StoreRequest;

use App\Http\Requests\Admin\ConfigStatus\UpdateRequest;

use Yajra\DataTables\Facades\DataTables;

use Str;

class ConfigStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ConfigStatus = ConfigStatus::paginate(10);
        return view('admin.config-status.index', ['ConfigStatus' => $ConfigStatus]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.config-status.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {

        $ConfigStatus = new ConfigStatus;
        $ConfigStatus->name = $request->name;
        $ConfigStatus->slug = Str::slug($request->name);
        $ConfigStatus->value = $request->value;
        $ConfigStatus->color = $request->color;
        $ConfigStatus->save();
        $notify = ['success' => "Config Status has been added."];

        return $notify;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ConfigStatus = ConfigStatus::findOrFail($id);
        return view('admin.config-status.edit', ['ConfigStatus' => $ConfigStatus]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $ConfigStatus = ConfigStatus::findOrFail($id);
        $ConfigStatus->name = $request->name;
        $ConfigStatus->value = $request->value;
        $ConfigStatus->color = $request->color;
        $ConfigStatus->save();
        $notify = ['success' => "Config Status has been updated."];

        return $notify;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ConfigStatus::findOrFail($id)->delete();
        $notify = ['success' => "Config Status has been deleted."];

        return $notify;
    }

    public function data(Request $var = null)
    {
        $data = ConfigStatus::get();

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
                        <li><a class="dropdown-item constatus-data-edit" href="#" data-constatus-id=' . $row->id . '>Edit</a></li>
                        <!--<li><a class="dropdown-item constatus-data-delete" href="#" data-constatus-id=' . $row->id . '>Delete</a></li>-->
                    </ul>
                </div>';
                return $actionBtn;
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at;
            })
            ->addColumn('color', function ($row) {
                return $row->color;
            })
            ->addColumn('value', function ($row) {
                return $row->value;
            })
            ->addColumn('name', function ($row) {
                return $row->name;
            })
            ->rawColumns(['action', 'created_at', 'color', 'value', 'name'])
            ->make(true);
    }
}
