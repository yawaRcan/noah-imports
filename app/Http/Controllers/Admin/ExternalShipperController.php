<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\ExternalShipper;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;

use App\Http\Requests\Admin\ExternalShipper\StoreRequest;

use App\Http\Requests\Admin\ExternalShipper\UpdateRequest;

use Yajra\DataTables\Facades\DataTables;

use Str;

class ExternalShipperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ExternalShipper = ExternalShipper::paginate(10);
        return view('admin.external-shipper.index', ['ExternalShipper' => $ExternalShipper]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.external-shipper.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $ExternalShipper = new ExternalShipper;
        $ExternalShipper->name = $request->name;
        $ExternalShipper->icon = $this->fileUpload($request->icon);
        $ExternalShipper->link = $request->link;
        $ExternalShipper->slug = Str::slug($request->name);
        $ExternalShipper->save();
        $notify = ['success' => "External Shipper has been added."];

        return $notify;
    }

    public function fileUpload($file, $oldFile = null)
    {
        if (isset($file)) {
            $fileFormats = ['image/jpeg', 'image/png', 'image/gif', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/pdf', 'text/plain'];
            if (!in_array($file->getClientMimeType(), $fileFormats)) {
                // return Reply::error('This file format not allowed');
            }
            if (Storage::exists('assets/icons/' . $oldFile)) {
                Storage::Delete('assets/icons/' . $oldFile);
                $file->storeAs('assets/icons/', $file->hashName());
                return $file->hashName();
                /* 
                  Storage::delete(['upload/test.png', 'upload/test2.png']);
                */
            } else {
                $file->storeAs('assets/icons/', $file->hashName());
                return $file->hashName();
            }
        } else {
            return $oldFile;
        }
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
        $ExternalShipper = ExternalShipper::findOrFail($id);
        return view('admin.external-shipper.edit', ['ExternalShipper' => $ExternalShipper]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $ExternalShipper = ExternalShipper::findOrFail($id);
        $ExternalShipper->name = $request->name;
        if (isset($request->icon)) {
            $ExternalShipper->icon = $this->fileUpload($request->icon, $ExternalShipper->icon);
        }
        $ExternalShipper->link = $request->link;
        $ExternalShipper->save();
        $notify = ['success' => "External Shipper has been updated."];

        return $notify;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ExternalShipper = ExternalShipper::findOrFail($id);
        if (Storage::exists('assets/icons/' . $ExternalShipper->icon)) {
            Storage::Delete('assets/icons/' . $ExternalShipper->icon);
        }
        $ExternalShipper->delete();
        $notify = ['success' => "External Shipper has been deleted."];

        return $notify;
    }

    public function data(Request $var = null)
    {
        $data = ExternalShipper::get();

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
                        <li><a class="dropdown-item exship-data-edit" href="#" data-exship-id=' . $row->id . '>Edit</a></li>
                        <!--<li><a class="dropdown-item exship-data-delete" href="#" data-exship-id=' . $row->id . '>Delete</a></li>-->
                    </ul>
                </div>';
                return $actionBtn;
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at;
            })
            ->addColumn('slug', function ($row) {
                return $row->slug;
            })
            ->addColumn('link', function ($row) {
                return $row->link;
            })
            ->addColumn('icon', function ($row) {
                return '<img class="img-fluid" src="' . asset('storage/assets/icons') . '/' . $row->icon . '" alt="" width="50px">';
            })
            ->addColumn('name', function ($row) {
                return $row->name;
            })
            ->rawColumns(['action', 'created_at', 'icon', 'link', 'slug', 'name'])
            ->make(true);
    }
}
