<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\CommunityPost;
use App\Models\CommunityComment;
use App\Models\CommunityLike;

class CommunityController extends Controller
{
    private function checkMenuAccess()
    {
        if (!Auth::user()->hasMenuAccess('community')) {
            abort(403, 'Your current package does not include Community Access. Please upgrade your plan.');
        }
    }

    public function index(Request $request)
    {
        $this->checkMenuAccess();

        $posts = CommunityPost::with(['user', 'comments', 'likes'])
            ->where(function ($q) {
                $q->where('is_published', true)
                  ->orWhere('user_id', Auth::id());
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('vendor.community.index', compact('posts'));
    }

    public function create()
    {
        $this->checkMenuAccess();
        return view('vendor.community.create');
    }

    public function store(Request $request)
    {
        $this->checkMenuAccess();

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('community_posts', 'public');
        }

        $post = CommunityPost::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
            'is_published' => true,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Community post published successfully.',
                'redirect' => route('vendor.community.index')
            ]);
        }

        return redirect()->route('vendor.community.index')->with('success', 'Community post published successfully.');
    }

    public function show($id)
    {
        $this->checkMenuAccess();

        $post = CommunityPost::with(['user', 'comments.user', 'likes'])->where('slug', $id)->orWhere('id', $id)->firstOrFail();

        if (!$post->is_published && $post->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(404, 'Post not found or unpublished.');
        }

        return view('vendor.community.show', compact('post'));
    }

    public function storeComment(Request $request, $id)
    {
        $this->checkMenuAccess();

        $request->validate([
            'comment' => 'required|string|max:2000',
        ]);

        $post = CommunityPost::where('slug', $id)->orWhere('id', $id)->firstOrFail();

        CommunityComment::create([
            'community_post_id' => $post->id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Comment added successfully.');
    }

    public function toggleLike($id)
    {
        $this->checkMenuAccess();

        $post = CommunityPost::where('slug', $id)->orWhere('id', $id)->firstOrFail();
        $userId = Auth::id();

        $existingLike = CommunityLike::where('community_post_id', $post->id)
            ->where('user_id', $userId)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            $post->decrement('likes_count');
            $liked = false;
        } else {
            CommunityLike::create([
                'community_post_id' => $post->id,
                'user_id' => $userId,
            ]);
            $post->increment('likes_count');
            $liked = true;
        }

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'liked' => $liked,
                'likes_count' => $post->likes_count,
            ]);
        }

        return redirect()->back();
    }

    public function destroy($id)
    {
        $this->checkMenuAccess();

        $post = CommunityPost::where('slug', $id)->orWhere('id', $id)->firstOrFail();

        if ($post->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'You are not authorized to delete this post.');
        }

        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('vendor.community.index')->with('success', 'Post deleted successfully.');
    }
}
