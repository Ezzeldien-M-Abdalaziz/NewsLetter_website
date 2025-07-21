<?php

namespace App\Http\Controllers\Frontend\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\SettingRequest;
use App\Models\User;
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

        //check if request has image
        if ($request->hasFile('image')) {
            //delete image if exist
            if(File::exists(public_path($user->image))){
                File::delete(public_path($user->image));
            }
            //upload new image
            $file = $request->file('image');
            $filename = Str::uuid() . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads/users', $filename , ['disk' => 'uploads']);

            $user->update([
                'image' => $path
            ]);
        }
        return redirect()->back()->with('success' , 'setting updated successfully');
    }
}
