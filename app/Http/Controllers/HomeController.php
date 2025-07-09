<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 'publish')->orderBy('created_at', 'desc')->take(3)->get();

        return view('index', compact('posts'));
    }

    public function loadMorePost(Request $request)
    {
        $offset = $request->input('offset', 0);

        $posts = Post::where('status', 'publish')
            ->orderBy('created_at', 'desc')
            ->skip($offset)
            ->take(3)
            ->get();

        return view('posts.post-card', compact('posts'))->render();
    }
}
