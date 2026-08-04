<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class VendorReviewController extends Controller
{
    public function index(Request $request)
    {
        $vendorId = auth()->id();

        $query = Review::with(['booking', 'vehicle', 'user'])
            ->where('vendor_id', $vendorId);

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('vehicle', function($vq) use ($search) {
                    $vq->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('booking', function($bq) use ($search) {
                    $bq->where('reservation_number', 'like', "%{$search}%");
                })
                ->orWhere('comment', 'like', "%{$search}%");
            });
        }

        $reviews = $query->latest()->paginate(15)->appends($request->all());

        $totalReviews = Review::where('vendor_id', $vendorId)->count();
        $avgRating = $totalReviews > 0 ? (float)Review::where('vendor_id', $vendorId)->avg('rating') : 0.0;

        if ($request->ajax()) {
            $html = view('vendor.reviews.partials.table', compact('reviews'))->render();
            return response()->json([
                'status' => 'success',
                'html' => $html,
                'totalReviews' => $totalReviews,
                'avgRating' => number_format($avgRating, 1)
            ]);
        }

        return view('vendor.reviews.index', compact('reviews', 'avgRating', 'totalReviews'));
    }

    public function destroy(Request $request, $id)
    {
        $review = Review::where('vendor_id', auth()->id())->findOrFail($id);
        $review->delete();

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Review deleted successfully.'
            ]);
        }

        return redirect()->back()->with('success', 'Review deleted successfully.');
    }
}
