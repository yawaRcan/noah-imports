<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.emails.template.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort(403);
        return view('admin.emails.template.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort(403);
        $emailTemplate = new EmailTemplate;
        $emailTemplate->name = $request->name;
        $emailTemplate->save();
        $notify = ['success' => "Email Template has been added."];

        return $notify;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $emailTemplate = EmailTemplate::findOrFail($id);
        return view('admin.emails.template.edit', ['emailTemplate' => $emailTemplate]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $emailTemplate = EmailTemplate::findOrFail($id);
        $emailTemplate->title = $request->title;
        $emailTemplate->subject = $request->subject;
        $emailTemplate->notice = $request->notice;
        $emailTemplate->body = $request->body;
        $emailTemplate->variables = $request->variables;
        $emailTemplate->save();
        $notify = ['success' => "Email Template has been updated."];

        return $notify;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort(403);
        EmailTemplate::findOrFail($id)->delete();
        $notify = ['success' => "Email Template has been deleted."];

        return $notify;
    }

    public function data(Request $var = null)
    {
        $data = EmailTemplate::get();

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
                        <li><a class="dropdown-item emailTemp-data-edit" href="' . route('email.templates.edit', [$row->id]) . '">Edit</a></li>
                        <li><a class="dropdown-item emailTemp-data-delete hide" href="#" data-emailTemp-id=' . $row->id . '>Delete</a></li>
                    </ul>
                </div>';
                return $actionBtn;
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at;
            })
            ->addColumn('notice', function ($row) {
                return $row->notice;
            })
            ->addColumn('slug', function ($row) {
                return $row->slug;
            })
            ->addColumn('title', function ($row) {
                return $row->title;
            })
            ->rawColumns(['action', 'created_at', 'notice', 'slug', 'title'])
            ->make(true);
    }
}
