<?php

namespace App\Http\Controllers\Frontend\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\SettingRequest;
use App\Models\User;
use App\Utils\ImageManager;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


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
}
