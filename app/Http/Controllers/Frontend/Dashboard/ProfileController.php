<?php

namespace App\Http\Controllers\Frontend\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function index(){
        return view('frontend.dashboard.profile');
    }

    public function storePost(PostRequest $request){

        try{

            DB::beginTransaction();
            $request->validated();
            $request->comment_able == "on" ? $request->merge(['comment_able' => 1]) : $request->merge(['comment_able' => 0]);   // overwrite the value of the comment_able field

            //another way
            //$request->merge(['user_id' => auth()->user()->id]);   // add the user_id field to the request
            // $post = Post::create($request->except('_token' , 'images')); //token is sent by the form by default , so we need to remove it because it is not a field in the database

            //best way
            $post = auth()->user()->posts()->create($request->except('_token' , 'images')); //token is sent by the form by default , so we need to remove it because it is not a field in the database

            if($request->hasFile('images')){
                foreach($request->file('images') as $image){
                    $file = $post->slug . '-' . time() . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs('uploads/posts', $file , ['disk' => 'uploads']);
                    $post->images()->create([
                        'path' => $path
                    ]);
                }
            }
            DB::commit();


        }catch(\Exception $e){
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }


        Session::flash('success', 'Post created successfully');

        return back();

    }



}
