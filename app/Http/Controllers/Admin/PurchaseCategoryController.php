<?php

namespace App\Http\Controllers\Admin; 

use Illuminate\Support\Str;

use Illuminate\Http\Request;

use App\Models\PurchaseCategory; 

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;

use Yajra\DataTables\Facades\DataTables;

use App\Http\Requests\Admin\Category\UpdateRequest; 

use App\Http\Requests\Admin\Category\CreateRequest; 


class PurchaseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.purchasing.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.purchasing.category.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        $Category = new PurchaseCategory();
        $Category->title = (isset($request->title)) ? $request->title : '';
        $Category->slug = (isset($request->title)) ? Str::slug($request->title) : '';
        $Category->summary = (isset($request->category_sum)) ? $request->category_sum  : '';  
        $Category->added_by = (isset(Auth::guard('admin')->user()->id)) ? Auth::guard('admin')->user()->id  : 1;
        $Category->photo = (isset($request->category_file)) ? $this->fileUpload($request->category_file)  : 'upload.png';
        $Category->status = 'active';
        $Category->save();
        $notify = ['success' => "Category has been added."];

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
        $Category = PurchaseCategory::findOrFail($id);
        return view('admin.purchasing.category.edit', ['Category' => $Category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $Category = PurchaseCategory::findOrFail($id);
        $Category->title = (isset($request->title)) ? $request->title : '';
        if ($Category->title != $request->title) {
            $Category->slug = (isset($request->title)) ? Str::slug($request->title) : '';
        }
        $Category->summary = (isset($request->category_sum)) ? $request->category_sum  : '';
        if($request->category_file){
            $Category->photo = (isset($request->category_file)) ? $this->fileUpload($request->category_file, $Category->photo)  : 'upload.png';
        } 
        $Category->save();
        $notify = ['success' => "Category has been updated."];
        return $notify;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        PurchaseCategory::findOrFail($id)->delete();
        $notify = ['success' => "Category has been deleted."];

        return $notify;
    }

    public function data(Request $var = null)
    {
        $data = PurchaseCategory::get();

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
                        <li><a class="dropdown-item category-data-edit" href="#" data-category-id=' . $row->id . '>Edit</a></li>
                        <li><a class="dropdown-item category-data-delete" href="#" data-category-id=' . $row->id . '>Delete</a></li>
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
            ->addColumn('created_by', function ($row) {
                return $row->user->first_name;
            })
            ->addColumn('image', function ($row) {

                $html = '<img class="nl-exship-category-add-preview" src="'.asset('storage/assets/category').'/'.$row->photo.'" width="30" />';

                return $html;
            })
            ->addColumn('summary', function ($row) {
                return $row->summary;
            })
            ->addColumn('slug', function ($row) {
                return $row->slug;
            })
            ->addColumn('title', function ($row) {
                return $row->title;
            })
            ->rawColumns(['action', 'created_at', 'status', 'created_by', 'image', 'summary', 'slug', 'title'])
            ->make(true);
    }

    public function fileUpload($file, $oldFile = null)
    {
        if (isset($file)) {
            $fileFormats = ['image/jpeg', 'image/png', 'image/gif', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/pdf', 'text/plain'];
            if (!in_array($file->getClientMimeType(), $fileFormats)) {
                // return Reply::error('This file format not allowed');
            }
            if (Storage::exists('assets/category/' . $oldFile)) {
                Storage::Delete('assets/category/' . $oldFile);
                $file->storeAs('assets/category/', $file->hashName());
                return $file->hashName();
                /* 
                  Storage::delete(['upload/test.png', 'upload/test2.png']);
                */
            } else {
                $file->storeAs('assets/category/', $file->hashName());
                return $file->hashName();
            }
        } else {
            return $oldFile;
        }
    }
}
