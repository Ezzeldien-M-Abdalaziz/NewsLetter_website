<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'search' => 'required|string'
        ]);

        $posts = Post::where('title' , 'like' , '%' . $request->search . '%')
        ->orWhere('desc' , 'like' , '%' . $request->search . '%')
        ->paginate(14);

        return view('frontend.search' , compact('posts'));
    }
}
