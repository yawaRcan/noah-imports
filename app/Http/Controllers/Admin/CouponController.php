<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;

use Illuminate\Http\Request;

use App\Models\EcommerceCoupon;

use App\Http\Controllers\Controller;

use Yajra\DataTables\Facades\DataTables;

use App\Http\Requests\Admin\Coupon\CreateRequest;

use App\Http\Requests\Admin\Coupon\UpdateRequest;

class CouponController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.ecommerce.coupon.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.ecommerce.coupon.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        $Coupon = new EcommerceCoupon;
        $Coupon->code = (isset($request->code)) ? $request->code : '';
        $Coupon->type = (isset($request->type)) ? $request->type : 'fixed';    
        $Coupon->value = (isset($request->value)) ? $request->value : 0;    
        $Coupon->status = (isset($request->status)) ? $request->status : 'inactive';    
        $Coupon->save();
        $notify = ['success' => "Coupon has been added."];

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
        $coupon = EcommerceCoupon::findOrFail($id);
        return view('admin.ecommerce.coupon.edit', ['coupon' => $coupon]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $Coupon = EcommerceCoupon::findOrFail($id);
        $Coupon->code = (isset($request->code)) ? $request->code : '';
        $Coupon->type = (isset($request->type)) ? $request->type : 'fixed';    
        $Coupon->value = (isset($request->value)) ? $request->value : 0;    
        $Coupon->status = (isset($request->status)) ? $request->status : 'inactive';   
        $Coupon->save();
        $notify = ['success' => "Coupon has been updated."];
        return $notify;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        EcommerceCoupon::findOrFail($id)->delete();
        $notify = ['success' => "Coupon has been deleted."];

        return $notify;
    }

    public function data(Request $var = null)
    {
        $data = EcommerceCoupon::get();

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
                        <li><a class="dropdown-item coupon-data-edit" href="#" data-coupon-id=' . $row->id . '>Edit</a></li>
                        <li><a class="dropdown-item coupon-data-delete" href="#" data-coupon-id=' . $row->id . '>Delete</a></li>
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
            ->addColumn('value', function ($row) {
                return $row->value;
            }) 
            ->addColumn('type', function ($row) {
                return $row->type;
            })
            ->addColumn('code', function ($row) {
                return $row->code;
            })
            ->rawColumns(['action', 'created_at', 'status', 'slug', 'title'])
            ->make(true);
    } 
}
