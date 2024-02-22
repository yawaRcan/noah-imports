<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;

use Illuminate\Support\Str;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Yajra\DataTables\Facades\DataTables; 

use App\Http\Requests\Admin\Brand\CreateRequest;

use App\Http\Requests\Admin\Brand\UpdateRequest;

class BrandController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.ecommerce.brand.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.ecommerce.brand.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        $Brand = new Brand;
        $Brand->title = (isset($request->title)) ? $request->title : '';
        $Brand->slug = (isset($request->title)) ? Str::slug($request->title) : '';    
        $Brand->save();
        $notify = ['success' => "Brand has been added."];

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
        $Brand = Brand::findOrFail($id);
        return view('admin.ecommerce.brand.edit', ['Brand' => $Brand]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $Brand = Brand::findOrFail($id);
        $Brand->title = (isset($request->title)) ? $request->title : '';
        if ($Brand->title != $request->title) {
            $Brand->slug = (isset($request->title)) ? Str::slug($request->title) : '';
        } 
        $Brand->save();
        $notify = ['success' => "Brand has been updated."];
        return $notify;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Brand::findOrFail($id)->delete();
        $notify = ['success' => "Brand has been deleted."];

        return $notify;
    }

    public function data(Request $var = null)
    {
        $data = Brand::get();

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
                        <li><a class="dropdown-item brand-data-edit" href="#" data-brand-id=' . $row->id . '>Edit</a></li>
                        <li><a class="dropdown-item brand-data-delete" href="#" data-brand-id=' . $row->id . '>Delete</a></li>
                    </ul>
                </div>';
                return $actionBtn;
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at;
            })
            ->addColumn('status', function ($row) {
                return $row->status;
            }) 
            ->addColumn('slug', function ($row) {
                return $row->slug;
            })
            ->addColumn('title', function ($row) {
                return $row->title;
            })
            ->rawColumns(['action', 'created_at', 'status', 'slug', 'title'])
            ->make(true);
    } 
}
