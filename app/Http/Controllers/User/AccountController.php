<?php

namespace App\Http\Controllers\User;

use Auth;
use App\Models\User;
use App\Events\UserEvent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\User\UserAccount\UpdateRequest;

class AccountController extends Controller
{
    public function userAccount(){
        $user = Auth::user();
        return view('user.account.view',compact('user'));
    }

    public function updateAccount(UpdateRequest $request,$id){
        User::findOrFail($id)->update([
            'country_id' => $request->country_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'customer_no' => $request->customer_no,
            'company' => $request->company,
            'username' => $request->username,
            'email' => $request->email,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'phone' => $request->phone,
            'initial_country' => $request->initial_country,
            'country_code' => $request->country_code,
        ]);

        $user = User::find($id);

        event(new UserEvent($user, $user, 'UpdateUser'));

        $notify = [
            'success' => "Account updated successfully.",
            'redirect' => route('user.account.index'),
        ];
        return $notify;
    }

    public function userProfilePrivacy(){
        $user = Auth::user();
        return view('user.account.profile',compact('user'));
    }

    public function updateProfilePrivacy(UpdateRequest $request,$id){
        $privacy = User::findOrFail($id);
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
        $password = User::findOrFail($id);
        $password->password = Hash::make($request->password);
        $password->save();

        event(new UserEvent($password, $password, 'ChangePassword'));

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
            if (Storage::exists('assets/user-profile/' . $oldFile)) {
                Storage::Delete('assets/user-profile/' . $oldFile);
                $file->storeAs('assets/user-profile/', $file->hashName());
                return $file->hashName();
                /* 
                  Storage::delete(['upload/test.png', 'upload/test2.png']);
                */
            } else {
                $file->storeAs('assets/user-profile/', $file->hashName());
                return $file->hashName();
            }
        } else {
            return $oldFile;
        }
    }


}
