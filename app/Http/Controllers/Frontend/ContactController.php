<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ContactController extends Controller
{
    public function index(){
        return view('frontend.contact');
    }

    public function store(ContactRequest $request){
        $request->validated();

        $request->merge([
            'ip_address' => $request->ip()
        ]);

        $contact = Contact::create($request->except('_token()')); //token is sent by the form by default , so we need to remove it because it is not a field in the database

        if(!$contact){
            Session::flash('error', 'Something went wrong');
            return redirect()->back();
        }
        Session::flash('success', 'Message sent successfully');
        return redirect()->back();
    }
}
