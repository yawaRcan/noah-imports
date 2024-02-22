<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\UserEmailNotification;

class AnnouncementController extends Controller
{
    public function create()
    {
        return view('admin.announcement.create');
    }

    public function store(Request $request)
    {
        $this->validate(
          $request,
          [
            'email'=> 'required',
            'subject'=> 'required',
            'message'=> 'required',
          ],
          [
            'email.required' => 'Email is required',
            'subject.required' => 'Subject is required',
            'message.required' => 'Message is required',
          ]
        );

        $content['subject'] = $request->subject;
        $content['body'] = $request->message;

        $users = User::all();
        
        $notification = new UserEmailNotification($content);
        
        // Send the notification to all users
        foreach ($users as $user) {
            $user->notify($notification);
        }

        $notify[] = ['success', "Email sent successfully."];
        return redirect()->back()->withNotify($notify);
    }
}
