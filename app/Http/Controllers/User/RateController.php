<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Branch;
use App\Models\Rate;

class RateController extends Controller
{
    public function index()
    {
        $branch = Branch::all();
        return view('user.rate.index', ['branch' => $branch]);
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
            // ->addColumn('created_at', function ($row) {
            //     return $row->created_at;
            // })
            ->addColumn('kg', function ($row) {
                return $row->kg;
            })
            ->addColumn('amount', function ($row) {
                return $row->amount;
            })
            ->rawColumns(['created_at', 'kg', 'amount'])
            ->make(true);
    }
}
