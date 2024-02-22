<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Discount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Discount\StoreRequest;
use App\Http\Requests\Admin\Discount\UpdateRequest;
use Yajra\DataTables\Facades\DataTables;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Discount = Discount::with('user')->paginate(10);
        return view('admin.discount.index', ['Discount' => $Discount]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::select('id', 'first_name', 'last_name')->get();
        return view('admin.discount.add', ['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {

        $Discount = new Discount;
        $Discount->description = $request->description;
        $Discount->code = $request->code;
        $Discount->value = $request->value;
        $Discount->user_id = $request->user_id;
        $Discount->save();
        $notify = ['success' => "Discount has been added."];

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
        $users = User::select('id', 'first_name', 'last_name')->get();
        $Discount = Discount::findOrFail($id);
        return view('admin.discount.edit', ['Discount' => $Discount, 'users' => $users]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $Discount = Discount::findOrFail($id);
        $Discount->description = $request->description;
        $Discount->code = $request->code;
        $Discount->value = $request->value;
        $Discount->user_id = $request->user_id;
        $Discount->save();
        $notify = ['success' => "Discount has been updated."];

        return $notify;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Discount::findOrFail($id)->delete();
        $notify = ['success' => "Discount has been deleted."];

        return $notify;
    }
    public function data(Request $var = null)
    {
        $data = Discount::with('user')->get();

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
                        <li><a class="dropdown-item discount-data-edit" href="#" data-discount-id=' . $row->id . '>Edit</a></li>
                        <li><a class="dropdown-item discount-data-delete" href="#" data-discount-id=' . $row->id . '>Delete</a></li>
                    </ul>
                </div>';
                return $actionBtn;
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at;
            })
            ->addColumn('user', function ($row) {
                return $row->user->first_name.' '.$row->user->last_name;
            })
            ->addColumn('description', function ($row) {
                return $row->description;
            })
            ->addColumn('value', function ($row) {
                return $row->value;
            })
            ->rawColumns(['action', 'created_at', 'value', 'description', 'user'])
            ->make(true);
    }
}
