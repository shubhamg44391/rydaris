<?php

namespace App\Http\Controllers\Admin;

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
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.community.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.community.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('community_posts', 'public');
        }

        CommunityPost::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Community post published successfully.',
                'redirect' => route('admin.community.index')
            ]);
        }

        return redirect()->route('admin.community.index')->with('success', 'Community post published successfully.');
    }

    public function show($id)
    {
        $post = CommunityPost::with(['user', 'comments.user'])->findOrFail($id);

        return view('admin.community.show', compact('post'));
    }

    public function storeReply(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:2000',
        ]);

        $post = CommunityPost::findOrFail($id);

        $comment = CommunityComment::create([
            'community_post_id' => $post->id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            $comment->load('user');
            return response()->json([
                'success' => true,
                'message' => 'Answer / Reply posted successfully.',
                'comment' => [
                    'id' => $comment->id,
                    'user_name' => $comment->user->name ?? 'User',
                    'user_role' => $comment->user->role ?? 'user',
                    'user_initials' => strtoupper(substr($comment->user->name ?? 'U', 0, 2)),
                    'company_name' => $comment->user->company_name ?? '',
                    'comment' => nl2br(e($comment->comment)),
                    'created_at' => $comment->created_at->format('d M Y, h:i A'),
                    'diff_for_humans' => $comment->created_at->diffForHumans(),
                    'destroy_url' => route('admin.community.reply.destroy', $comment->id)
                ]
            ]);
        }

        return redirect()->back()->with('success', 'Answer / Reply posted successfully.');
    }

    public function destroyReply($id)
    {
        $comment = CommunityComment::findOrFail($id);
        $comment->delete();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Answer / Reply deleted successfully.'
            ]);
        }

        return redirect()->back()->with('success', 'Answer / Reply deleted successfully.');
    }

    public function destroy($id)
    {
        $post = CommunityPost::findOrFail($id);
        $post->delete();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Post deleted successfully.',
                'redirect' => route('admin.community.index')
            ]);
        }

        return redirect()->route('admin.community.index')->with('success', 'Post deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $post = CommunityPost::findOrFail($id);
        $post->is_published = !$post->is_published;
        $post->save();

        $statusStr = $post->is_published ? 'published (public)' : 'unpublished (private)';

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'is_published' => $post->is_published,
                'message' => "Post is now {$statusStr}."
            ]);
        }

        return redirect()->back()->with('success', "Post is now {$statusStr}.");
    }
}
