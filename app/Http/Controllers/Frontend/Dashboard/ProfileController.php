<?php

namespace App\Http\Controllers\Frontend\Dashboard;

use App\Utils\ImageManager;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function index(){
        $posts = auth()->user()->posts()->active()->with('images')->latest()->get();
        return view('frontend.dashboard.profile' , compact('posts'));
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

            //upload images
            ImageManager::uploadImages($request, $post);
            DB::commit();

            //forget the read more posts cache to refresh it and show the new post ,, this is optional if u want the new posts immediately
            Cache::forget('read_more_posts');
            Cache::forget('latest_posts');

        }catch(\Exception $e){
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }

        Session::flash('success', 'Post created successfully');
        return back();
    }


    public function editPost($slug){

    }

    public function deletePost(Request $request){
        $request->validate([
            'post_id' => 'required|exists:posts,id'
        ]);

        $post = Post::findOrFail($request->post_id);

        ImageManager::deleteImages($post);

        $post->delete();
        Session::flash('success', 'Post deleted successfully');
        return back();
    }

    public function getComments($postId){
        $post = Post::findOrFail(id: $postId);
        $comments = $post->comments()->with('user')->get();
        if(!$comments){
            return response()->json([
                'status' => false,
                'message' => 'Comments not found'
            ]);
        }
        return response()->json([
            'status' => true,
            'comments' => $comments,
            'message' => 'Comments found'
        ]);
    }



}
