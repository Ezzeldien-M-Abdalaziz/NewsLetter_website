<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Notifications\newCommentNotify;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show($slug){
        $mainPost = Post::active()->with(['comments'=>function($query){
            $query->latest()->limit(3);
        }])->whereSlug($slug)->first();
        $category = $mainPost->category;
        $posts_belongs_to_category = $category->posts()->select('id', 'title', 'slug')->limit(6)->get();

        //increment views
        $mainPost->increment('num_of_views');

        return view('frontend.show', compact('mainPost', 'category', 'posts_belongs_to_category'));
    }

    public function getAllPosts($slug){
        $post = Post::active()->whereSlug($slug)->first();
        if(!$post){
            return response()->json([
                'status' => false,
                'message' => 'Post not found'
            ]);
        }

        $comments = $post->comments()->with('user')->get();
        return response()->json($comments);
    }

    public function saveComment(Request $request){

        $request->validate([
            'user_id' => 'required | exists:users,id',
            'comment' => 'required | string | max:255',
            'post_id' => 'required | exists:posts,id'
        ]);
        $comment = Comment::create([
            'user_id' => $request->user_id,
            'post_id' => $request->post_id,
            'comment' => $request->comment,
            'ip_address' => $request->ip()
        ]);

        //send notofication
        $post = Post::findOrFail($request->post_id);
        $user = $post->user;
        $user->notify(new newCommentNotify($comment, $post));
        //end notofication

        //to eager load the relationship
        $comment->load('user');

        if(!$comment){
            return response()->json([
                'status' => 403,
                'message' => 'Something went wrong'
            ]);
        }

        return response()->json([
            'status' => 201,
            'comment' => $comment,
        ]);
    }
}
