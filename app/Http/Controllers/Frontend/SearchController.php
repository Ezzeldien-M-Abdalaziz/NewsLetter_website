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
            'search' => 'nullable|string|max:100'
        ]);

        $keyword = strip_tags($request->search);

        $posts = Post::active()->where('title' , 'like' , '%' . $keyword. '%')
        ->orWhere('desc' , 'like' , '%' . $keyword . '%')
        ->paginate(14);

        return view('frontend.search' , compact('posts'));
    }
}
