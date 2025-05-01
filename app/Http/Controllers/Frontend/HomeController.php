<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::with('images')->latest()->paginate(9);
        $greatest_posts_views = Post::orderBy('num_of_views', 'desc')->take(5)->get();
        $oldest_news = Post::oldest()->take(3)->get();

        $greatest_posts_comments = Post::withCount('comments')
            ->orderBy('comments_count', 'desc')
            ->take(3)
            ->get();

        return view('frontend.index', compact('posts' , 'greatest_posts_views' , 'oldest_news' , 'greatest_posts_comments'));
    }
}
