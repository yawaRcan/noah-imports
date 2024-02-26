<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;

use App\Models\Order;
use App\Models\Admin;

use Carbon\Carbon;
use App\Models\Parcel;

use App\Models\Wallet;
use App\Events\UserEvent;
use App\Models\Consolidate;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Stevebauman\Location\Facades\Location;
use App\Notifications\UserEmailNotification;
use App\Http\Requests\Admin\ShipmentMode\UpdateRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $User = User::paginate(10);
        return view('admin.user.index', ['User' => $User]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $User = User::findOrFail($id);
        return view('admin.user.edit', ['User' => $User]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ids = DB::table('consolidate_pivot')->pluck('parcel_id')->toArray();
        $count['parcels'] = Parcel::where('user_id', $id)->orderBy('id', 'desc')->whereNull('drafted_at')->whereNotIn('id', $ids)->where('parcel_status_id', '!=', 5)->count();
        $count['archived_parcels'] = Parcel::where(['user_id' => $id, 'payment_status_id' => 2, 'parcel_status_id' => 5])->orderBy('id', 'desc')->whereNull('drafted_at')->whereNotIn('id', $ids)->count();
        $count['consolidate'] = Consolidate::where('user_id', $id)->count();
        $count['purchases'] = Order::where('user_id', $id)->count();
        $count['wallets'] = Wallet::where('morphable_id', $id)->whereHasMorph('morphable', [User::class])->count();
        $wallets = Wallet::where('morphable_id', $id)->whereHasMorph('morphable', [User::class])->get();
        $user = User::findOrFail($id);
        $geoLocation = Location::get($user->ip);
        // $ip = "154.192.158.8"; /* Static IP address */
        // $geoLocation = Location::get($ip);
        // dd($geoLocation);
        return view('admin.user.show', compact('user', 'wallets', 'count', 'geoLocation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        ini_set('max_execution_time', 500);
        ini_set('memory_limit', '700M');
        $admin = Admin::findOrFail(\Auth::guard('admin')->id());
        $User = User::findOrFail($id);
        $template = EmailTemplate::where('slug', 'active-user')->first();
        $shortCodes = [];
        $User->email = $request->email;
        if ($User->status != $request->status) {
            // if($request->status == 1){
            //     $User->email_verified_at = Carbon::now();
            // }
            // if($request->status == 0){
            //     $User->email_verified_at = null;
            //     //  event(new UserEvent($template , $shortCodes,$User, $admin, 'DeactiveUserByAdmin')); 
            //      event(new UserEvent($template , $shortCodes,$User, $admin, 'DeactiveUserByAdmin')); 
            //         event(new UserEvent($template , $shortCodes,$User, $User, 'DeactiveUser')); 
            // }

            if ($request->status == 1) {
                //Notifictaion to Admin
                $template1 = EmailTemplate::where('slug', 'ActiveUserByAdmin')->first();
                $loginUrl = route('login');
                if ($template1) {
                    $shortCodes = [
                        'NAME' => $admin->first_name . ' ' . $admin->last_name,
                        'Username' => $User->first_name . ' ' . $User->last_name,
                        'Login_Url' => $loginUrl
                    ];
                    event(new UserEvent($template1, $shortCodes, $User, $admin, 'ActiveUserByAdmin'));
                    //Notifictaion to User
                    $template = EmailTemplate::where('slug', 'active-user')->first();
                    $shortCodes = [
                        'Username' => $User->first_name . ' ' . $User->last_name,
                        'Login_Url' => $loginUrl
                    ];
                    event(new UserEvent($template, $shortCodes, $User, $User, 'ActiveUser'));
                } else {
                    $notify = [
                        'error' => "Something went wrong contact your admin.",
                    ];
                }
            }

            $User->status = $request->status;
        }




        $User->save();
        // $template = EmailTemplate::where('slug', 'update-user')->first();

        // if ($template) {

        //     $shortCodes = [];

        //     //Send notification to user
        //     event(new UserEvent($template, $shortCodes, $User, $User, 'UpdateUser'));
        // } else {

        //     $notify = [
        //         'error' => "Something went wrong contact your admin.",
        //     ];

        //     // return $notify;
        // }

        $notify = ['success' => "User has been updated."];

        return $notify;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();
        $notify = ['success' => "User has been deleted."];

        return $notify;
    }

    public function data(Request $var = null)
    {
        $data = User::get();
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
                        <li><a class="dropdown-item user-data-view" href="' . route('user.val.show', [$row->id]) . '">View</a></li>
                        <li><a class="dropdown-item user-data-edit" href="#" data-user-id=' . $row->id . '>Edit</a></li>
                        <li><a class="dropdown-item user-data-delete" href="#" data-user-id=' . $row->id . '>Delete</a></li>
                        <li><a class="dropdown-item user-send-email" href="#" data-user-id=' . $row->id . '>Send Email</a></li>
                    </ul>
                </div>';
                return $actionBtn;
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at;
            })
            ->addColumn('name', function ($row) {
                $fullName = $row->first_name . ' ' . $row->last_name;
                $customerNo = $row->customer_no;
                $html = "<a href='" . route('user.val.show', [$row->id]) . "'>" . $fullName . " / " . $customerNo . "</a>";
                return $html;
            })
            ->addColumn('status', function ($row) {
                if ($row->status == 1) {
                    $status = 'Active';
                } else {
                    $status = 'In Active';
                }

                return $status;
            })
            ->addColumn('invite_no', function ($row) {
                if (!is_null($row->invite_no)) {
                    return $row->invite_no;
                } else {
                    return 'N/A ';
                }
            })
            ->addColumn('email', function ($row) {
                return $row->email;
            })
            ->rawColumns(['action', 'status', 'invite_no', 'email', 'name', 'created_at'])
            ->make(true);
    }

    public function sendEmail(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.send-email', ['user' => $user]);
    }

    public function postSendEmail(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $template = EmailTemplate::where('slug', 'user-notify')->first();

        if ($template) {
            $notification = new UserEmailNotification(
                $request->subject,
                $template,
                [
                    'message' => $request->message,
                ]
            );

            $user->notify($notification);
        } else {
            $notify = [
                'error' => "Something went wrong contact your admin.",
            ];
            return $notify;
        }

        $notify = ['success' => "Email sent successfully."];

        return $notify;
    }
}
