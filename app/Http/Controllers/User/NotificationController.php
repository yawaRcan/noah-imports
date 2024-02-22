<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAllRead() {
        Auth::user()->unreadNotifications->markAsRead();
        return true;
    }

    public function markAsRead(Request $request) { 
        Auth::user()->unreadNotifications->where('id',$request->id)->markAsRead(); 
        return true;
    }

}
