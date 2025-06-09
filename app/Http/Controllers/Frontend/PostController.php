<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show($slug){
        $post = Post::whereSlug($slug)->first();

        return view('frontend.show', compact('post'));
    }
}
