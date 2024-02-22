<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Payment;

use App\Http\Requests\Admin\Payment\StoreRequest;

use App\Http\Requests\Admin\Payment\UpdateRequest;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

use Str;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Payment = Payment::paginate(10);
        return view('admin.payment.index', ['Payment' => $Payment]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.payment.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $Payment = new Payment;
        $Payment->name = $request->name;
        if($request->icon){
            $Payment->icon = $this->fileUpload($request->icon);
        }
        $Payment->slug = Str::slug($request->name);
        $Payment->information = $request->information;
        $Payment->save();
        $notify = ['success' => "Payment has been added."];

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
        $Payment = Payment::findOrFail($id);
        return view('admin.payment.edit', ['Payment' => $Payment]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $Payment = Payment::findOrFail($id);
        if (isset($request->icon)) {
            $Payment->icon = $this->fileUpload($request->icon, $Payment->icon);
        }
        $Payment->name = $request->name;
        $Payment->information = $request->information;
        $Payment->save();
        $notify = ['success' => "Payment has been updated."];

        return $notify;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Payment::findOrFail($id)->delete();
        $notify = ['success' => "Payment has been deleted."];

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

    public function data(Request $var = null)
    {
        $data = Payment::get();

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
                        <li><a class="dropdown-item payment-data-edit" href="#" data-payment-id=' . $row->id . '>Edit</a></li>';
                       // $actionBtn .= 'li><a class="dropdown-item payment-data-delete" href="#" data-payment-id=' . $row->id . '>Delete</a></li>';
                    $actionBtn .='</ul>
                </div>';
                return $actionBtn;
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at;
            })
            ->addColumn('information', function ($row) {
                return '<span class="">' . Str::limit($row->information, 30) . '</span>';
            })
            ->addColumn('name', function ($row) {
                return $row->name;
            })
            ->rawColumns(['action', 'created_at', 'information', 'name'])
            ->make(true);
    }
}
