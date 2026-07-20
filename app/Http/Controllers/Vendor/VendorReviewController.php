<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class VendorReviewController extends Controller
{
    

    public function index()
    {
        $vendorId = auth()->id();

        $reviews = Review::with(['booking', 'vehicle', 'user'])
            ->where('vendor_id', $vendorId)
            ->latest()
            ->paginate(15);

        $avgRating = Review::where('vendor_id', $vendorId)->avg('rating') ?: 5.0;
        $totalReviews = Review::where('vendor_id', $vendorId)->count();

        return view('vendor.reviews.index', compact('reviews', 'avgRating', 'totalReviews'));
    }

    

    public function destroy($id)
    {
        $review = Review::where('vendor_id', auth()->id())->findOrFail($id);
        $review->delete();

        return redirect()->back()->with('success', 'Review deleted successfully.');
    }
}
