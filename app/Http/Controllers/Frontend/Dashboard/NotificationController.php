<?php

namespace App\Http\Controllers\Frontend\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return view('frontend.dashboard.notification');
    }

    public function delete(Request $request)
    {
        auth()->user()->notifications()->where('id' , $request->id)->delete();
        return redirect()->back()->with('success' , 'Notification deleted successfully');
    }

    public function deleteAll(Request $request)
    {
        auth()->user()->notifications()->delete();
        return redirect()->back()->with('success' , 'Notifications deleted successfully');
    }

    public function readAll(){
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }


}
