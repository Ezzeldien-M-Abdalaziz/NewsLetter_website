<?php

namespace App\Http\Controllers\Frontend\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\SettingRequest;
use App\Models\User;
use App\Utils\ImageManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function index(){
        return view('frontend.dashboard.setting');
    }

    public function update(SettingRequest $request){
        $user = User::findOrFail(auth()->user()->id);
        $user->update($request->except('_token' , 'image'));

        ImageManager::uploadImages($request , null , $user);

        return redirect()->back()->with('success' , 'setting updated successfully');
    }

    public function changePassword(Request $request){
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required' , 'string' , 'min:8' , 'confirmed'],
        ]);

        $user = User::findOrFail(auth()->user()->id);
        if(!password_verify($request->current_password , $user->password)){
            return redirect()->back()->with('error' , 'current password is incorrect');
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->back()->with('success' , 'password changed successfully');
    }
}
