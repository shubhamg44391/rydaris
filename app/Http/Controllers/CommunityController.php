<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CommunityPost;
use App\Models\CommunityComment;

class CommunityController extends Controller
{
    public function index(Request $request)
    {
        $posts = CommunityPost::with(['user', 'comments'])
            ->where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        return view('frontend.community.index', compact('posts'));
    }

    public function show($id)
    {
        $post = CommunityPost::with(['user', 'comments.user'])
            ->where('is_published', true)
            ->where(function ($query) use ($id) {
                $query->where('slug', $id)->orWhere('id', $id);
            })
            ->firstOrFail();

        $seo_title = $post->meta_title ?: ($post->title . ' | Rydaris Community');
        $seo_description = $post->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($post->content), 160);
        $seo_keyword = $post->keyword;

        return view('frontend.community.show', compact('post', 'seo_title', 'seo_description', 'seo_keyword'));
    }

    public function storeComment(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to post an answer or reply.');
        }

        $user = Auth::user();
        if ($user->role !== 'vendor' && $user->role !== 'admin' && $user->role !== 'super_admin') {
            return redirect()->back()->with('error', 'Only Vendors and Admins can post answers in the Community.');
        }

        $request->validate([
            'comment' => 'required|string|max:2000',
        ]);

        $post = CommunityPost::where('is_published', true)
            ->where(function ($query) use ($id) {
                $query->where('slug', $id)->orWhere('id', $id);
            })
            ->firstOrFail();

        CommunityComment::create([
            'community_post_id' => $post->id,
            'user_id' => $user->id,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Your answer has been posted successfully.');
    }
}
