<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Currency;

use App\Http\Requests\Admin\Currency\StoreRequest;

use App\Http\Requests\Admin\Currency\UpdateRequest;

use Yajra\DataTables\Facades\DataTables;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Currency = Currency::paginate(10);
        return view('admin.currency.index', ['Currency' => $Currency]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.currency.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {

        $Currency = new Currency;
        $Currency->name = $request->name;
        $Currency->code = $request->code;
        $Currency->symbol = $request->symbol;
        $Currency->value = $request->value;
        $Currency->save();
        $notify = ['success' => "Currency has been added."];

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
        $Currency = Currency::findOrFail($id);
        return view('admin.currency.edit', ['Currency' => $Currency]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $Currency = Currency::findOrFail($id);
        $Currency->name = $request->name;
        $Currency->code = $request->code;
        $Currency->symbol = $request->symbol;
        $Currency->value = $request->value;
        $Currency->save();
        $notify = ['success' => "Currency has been updated."];

        return $notify;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Currency::findOrFail($id)->delete();
        $notify = ['success' => "Currency has been deleted."];

        return $notify;
    }

    public function data(Request $var = null)
    {
        $data = Currency::get();

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
                        <li><a class="dropdown-item currency-data-edit" href="#" data-currency-id=' . $row->id . '>Edit</a></li>
                        <li><a class="dropdown-item currency-data-delete" href="#" data-currency-id=' . $row->id . '>Delete</a></li>
                    </ul>
                </div>';
                return $actionBtn;
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at;
            })
            ->addColumn('value', function ($row) {
                return $row->value;
            })
            ->addColumn('symbol', function ($row) {
                return $row->symbol;
            })
            ->addColumn('code', function ($row) {
                return $row->code;
            })
            ->addColumn('name', function ($row) {
                return $row->name;
            })
            ->rawColumns(['action', 'created_at', 'value', 'symbol', 'code', 'name'])
            ->make(true);
    }
}
