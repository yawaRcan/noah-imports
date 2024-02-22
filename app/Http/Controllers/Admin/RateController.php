<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rate;

use App\Models\Branch;
use App\Models\Currency;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\Rate\StoreRequest;

use App\Http\Requests\Admin\Rate\UpdateRequest;

use Yajra\DataTables\Facades\DataTables;

class RateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branch = Branch::all();
        return view('admin.rate.index', ['branch' => $branch]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branch = Branch::all();
        return view('admin.rate.add', ['branch' => $branch]);
    }

    /**
     * Store a newly created resource in storage.
     */
      public function store(StoreRequest $request)
      {
            $Rate = new Rate;
            // $currency = Currency::findOrFail(1);
            // $totalConverted = trim($request->amount) * $currency->value;
            $Rate->kg = $request->kg;
            $Rate->amount = $request->amount;
            $Rate->branch_id = $request->branch_id;
            $Rate->save();
            $notify = ['success' => "Rate has been added."];
    
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
        $branch = Branch::all();
        $Rate = Rate::findOrFail($id);
        return view('admin.rate.edit', ['Rate' => $Rate, 'branch' => $branch]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
       
        $Rate = Rate::findOrFail($id);
        $Rate->amount = $request->amount;
        $Rate->kg = $request->kg;
        $Rate->branch_id = $request->branch_id;
        $Rate->save();
        $notify = ['success' => "Rate has been updated."];

        return $notify;
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Rate::findOrFail($id)->delete();
        $notify = ['success' => "Rate has been deleted."];

        return $notify;
    }

    public function data(Request $request)
    {
        if (isset($request->branch)) {
            $data = Rate::where('branch_id', $request->branch)->get();
        } else {
            $data = Rate::get();
        }




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
                        <li><a class="dropdown-item rate-data-edit" href="#" data-rate-id=' . $row->id . '>Edit</a></li>
                        <li><a class="dropdown-item rate-data-delete" href="#" data-rate-id=' . $row->id . '>Delete</a></li>
                    </ul>
                </div>';
                return $actionBtn;
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at;
            })
            ->addColumn('kg', function ($row) {
                return $row->kg;
            })
            ->addColumn('amount', function ($row) {
                return $row->amount;
            })
            ->rawColumns(['action', 'created_at', 'kg', 'amount'])
            ->make(true);
    }
}
