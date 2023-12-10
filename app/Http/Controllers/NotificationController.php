<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Notified;


class NotificationController extends Controller
{
    public function show() 
    {
        $notifications = Notified::where('id_notified','=',Auth::user()->id)->orderBy('date', 'desc');
        return view('pages.notification',['notifications' => $notifications]);
    }
}
