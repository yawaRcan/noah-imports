<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\EmailTemplate;
use Auth;
use Illuminate\Support\Facades\Storage;
use App\Events\UserEvent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Http\Requests\Admin\UserAccount\UpdateRequest;

class AccountController extends Controller
{
    public function userAccount(){
        $user = Auth::user();
        return view('admin.account.view',compact('user'));
    }

    public function updateAccount(UpdateRequest $request,$id){
        Admin::findOrFail($id)->update([
            'country_id' => $request->country_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'phone' => $request->phone,
            'initial_country' => $request->initial_country,
            'country_code' => $request->country_code,
        ]);

        $admin = Admin::find($id);

        $template = EmailTemplate::where('slug', 'update-user')->first();

        if ($template) {

            $shortCodes = [];

            //Send notification to user
            event(new UserEvent($template , $shortCodes, $admin, $admin, 'UpdateUser')); 

        } else {

            $notify = [
                'error' => "Something went wrong contact your admin.",
            ];

            // return $notify;
        }

        $notify = [
            'success' => "Account updated successfully.",
            'redirect' => route('account.index'),
        ];
        return $notify;
    }

    public function userProfilePrivacy(){
        $user = Auth::user();
        return view('admin.account.profile',compact('user'));
    }

    public function updateProfilePrivacy(UpdateRequest $request,$id){
        $privacy = Admin::findOrFail($id);
        $privacy->theme = $request->theme;
        $privacy->timezone_id = $request->timezone_id;
        $privacy->lang = $request->lang;
        if (isset($request->image)) {
            $privacy->image = $this->fileUpload($request->image, $privacy->image);
        }
        $privacy->save();
        $notify = ['success' => "Privacy updated successfully."];

        return $notify;
    }

    public function updatePassword(UpdateRequest $request,$id){ 
        $admin = Admin::findOrFail($id);
        $admin->password = Hash::make($request->password);
        $admin->save();

        $template = EmailTemplate::where('slug', 'change-password')->first();

        if ($template) {

            $shortCodes = [];

            //Send notification to user
            event(new UserEvent($template , $shortCodes, $admin, $admin, 'ChangePassword')); 

        } else {

            $notify = [
                'error' => "Something went wrong contact your admin.",
            ];

            // return $notify;
        }

        $notify = ['success' => "Password updated successfully."];

        return $notify;
    }

    public function fileUpload($file, $oldFile = null)
    {
        if (isset($file)) {
            $fileFormats = ['image/jpeg', 'image/png', 'image/gif', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/pdf', 'text/plain'];
            if (!in_array($file->getClientMimeType(), $fileFormats)) {
                // return Reply::error('This file format not allowed');
            }
            if (Storage::exists('assets/admin-profile/' . $oldFile)) {
                Storage::Delete('assets/admin-profile/' . $oldFile);
                $file->storeAs('assets/admin-profile/', $file->hashName());
                return $file->hashName();
                /* 
                  Storage::delete(['upload/test.png', 'upload/test2.png']);
                */
            } else {
                $file->storeAs('assets/admin-profile/', $file->hashName());
                return $file->hashName();
            }
        } else {
            return $oldFile;
        }
    }


}
