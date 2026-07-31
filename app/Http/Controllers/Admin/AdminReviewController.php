<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\User;

class AdminReviewController extends Controller
{
    public function index(Request $request)
    {
        $rating = $request->query('rating');
        $vendorId = $request->query('vendor_id');
        $search = $request->query('search');

        $query = Review::with(['vendor', 'vehicle', 'user', 'booking'])->orderBy('created_at', 'desc');

        if ($rating) {
            $query->where('rating', $rating);
        }

        if ($vendorId) {
            $query->where('vendor_id', $vendorId);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('comment', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('name', 'like', '%' . $search . '%')->orWhere('email', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('vendor', function($v) use ($search) {
                      $v->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        $reviews = $query->paginate(15)->appends([
            'rating' => $rating,
            'vendor_id' => $vendorId,
            'search' => $search
        ]);

        $vendors = User::where('role', 'vendor')->orderBy('name')->get();

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'html' => view('admin.reviews.partials.table', compact('reviews', 'rating', 'vendorId', 'search'))->render(),
            ]);
        }

        return view('admin.reviews.index', compact('reviews', 'vendors', 'rating', 'vendorId', 'search'));
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        if (request()->ajax() || request()->wantsJson() || request()->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'message' => 'Review deleted successfully.'
            ]);
        }

        return redirect()->back()->with('success', 'Review deleted successfully.');
    }
}
