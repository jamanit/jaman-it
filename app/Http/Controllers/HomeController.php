<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Message;
use App\Models\Service;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;

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

    public function sendMessage(Request $request)
    {
        $key = 'contact-form:' . $request->ip();

        // Anti-spam rate limit (5 requests per 10 minutes per IP)
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Too many attempts. Please try again later.'
            ], 429);
        }

        RateLimiter::hit($key, 600);  // 600 seconds = 10 minutes

        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:100',
            'email'   => 'nullable|email:rfc,dns|max:100',
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Invalid data',
                'errors'  => $validator->errors()
            ], 422);
        }

        Message::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'message'    => $request->message,
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Message sent successfully!'
        ]);
    }
}
