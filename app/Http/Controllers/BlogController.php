<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogPost;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::where('is_published', true)
                         ->orderBy('created_at', 'desc')
                         ->paginate(9);
                         
        return view('frontend.blog.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = BlogPost::where('slug', $slug)
                        ->where('is_published', true)
                        ->firstOrFail();
                        
        return view('frontend.blog.show', compact('post'));
    }
}
