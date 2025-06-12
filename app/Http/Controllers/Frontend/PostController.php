<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show($slug){
        $post = Post::with(['comments'=>function($query){
            $query->limit(3);
        }])->whereSlug($slug)->first();
        $category = $post->category;
        $posts_belongs_to_category = $category->posts()->select('id', 'title', 'slug')->limit(6)->get();
        return view('frontend.show', compact('post', 'category', 'posts_belongs_to_category'));
    }
}
