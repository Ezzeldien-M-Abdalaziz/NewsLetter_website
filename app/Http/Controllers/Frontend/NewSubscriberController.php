<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\NewSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
   use Illuminate\Support\Facades\Validator;

class NewSubscriberController extends Controller
{

public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email|unique:new_subscribers',
    ]);

    if ($validator->fails()) {
        Session::flash('error', $validator->errors()->first('email'));
        return redirect()->back()->withInput();
    }

    $newSubscriber = NewSubscriber::create([
        'email' => $request->email
    ]);

    if (!$newSubscriber) {
        Session::flash('error', 'Something went wrong');
        return redirect()->back();
    }

    Session::flash('success', 'You have successfully subscribed');
    return redirect()->back();
}

}
