<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\VendorExtra;
use App\Models\VendorExtraFeature;
use App\Models\VendorRule;
use Illuminate\Support\Facades\Auth;

class ExtrasController extends Controller
{
    private function vendorId()
    {
        return Auth::id();
    }

    public function extrasIndex()
    {
        $extras = VendorExtra::where('vendor_id', $this->vendorId())->where('type', 'extra')->get();
        return view('vendor.extras.extras', compact('extras'));
    }

    public function createExtra()
    {
        $groups = Group::where('vendor_id', $this->vendorId())->orderBy('name')->get();
        $vendor_features = \App\Models\VendorFeature::where('vendor_id', $this->vendorId())->orderBy('index_no')->get();
        $insurances = VendorExtra::where('vendor_id', $this->vendorId())->where('type', 'insurance')->get();
        return view('vendor.extras.create', ['type' => 'extra', 'groups' => $groups, 'vendor_features' => $vendor_features, 'insurances' => $insurances]);
    }

    public function editExtra($id)
    {
        $item = VendorExtra::where('vendor_id', $this->vendorId())->findOrFail($id);
        $groups = Group::where('vendor_id', $this->vendorId())->orderBy('name')->get();
        $vendor_features = \App\Models\VendorFeature::where('vendor_id', $this->vendorId())->orderBy('index_no')->get();
        $insurances = VendorExtra::where('vendor_id', $this->vendorId())->where('type', 'insurance')->get();

        $existing_mappings = \DB::table('vendor_extra_feature_mappings')
            ->whereIn('vendor_extra_id', $insurances->pluck('id'))
            ->get()
            ->groupBy('vendor_feature_id')
            ->map(function ($items) {
                return $items->pluck('vendor_extra_id')->toArray();
            })
            ->toArray();

        return view('vendor.extras.edit', [
            'type' => 'extra', 
            'item' => $item, 
            'groups' => $groups, 
            'vendor_features' => $vendor_features, 
            'insurances' => $insurances,
            'existing_mappings' => $existing_mappings
        ]);
    }

    public function createInsurance()
    {
        $groups = Group::where('vendor_id', $this->vendorId())->orderBy('name')->get();
        $vendor_features = \App\Models\VendorFeature::where('vendor_id', $this->vendorId())->orderBy('index_no')->get();
        $insurances = VendorExtra::where('vendor_id', $this->vendorId())->where('type', 'insurance')->get();
        return view('vendor.extras.create', ['type' => 'insurance', 'groups' => $groups, 'vendor_features' => $vendor_features, 'insurances' => $insurances]);
    }

    public function editInsurance($id)
    {
        $item = VendorExtra::where('vendor_id', $this->vendorId())->findOrFail($id);
        $groups = Group::where('vendor_id', $this->vendorId())->orderBy('name')->get();
        $vendor_features = \App\Models\VendorFeature::where('vendor_id', $this->vendorId())->orderBy('index_no')->get();
        $insurances = VendorExtra::where('vendor_id', $this->vendorId())->where('type', 'insurance')->get();

        $existing_mappings = \DB::table('vendor_extra_feature_mappings')
            ->whereIn('vendor_extra_id', $insurances->pluck('id'))
            ->get()
            ->groupBy('vendor_feature_id')
            ->map(function ($items) {
                return $items->pluck('vendor_extra_id')->toArray();
            })
            ->toArray();

        return view('vendor.extras.edit', [
            'type' => 'insurance', 
            'item' => $item, 
            'groups' => $groups, 
            'vendor_features' => $vendor_features, 
            'insurances' => $insurances,
            'existing_mappings' => $existing_mappings
        ]);
    }

    public function insuranceIndex()
    {
        $insurances = VendorExtra::where('vendor_id', $this->vendorId())->where('type', 'insurance')->get();
        return view('vendor.extras.insurance', compact('insurances'));
    }



    public function rulesIndex()
    {
        $rules = VendorRule::where('vendor_id', $this->vendorId())->get();
        return view('vendor.extras.rules', compact('rules'));
    }

    // --- Extras & Insurance ---
    public function storeExtra(Request $request)
    {
        $request->validate([
            'type' => 'required|in:extra,insurance',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'arrival_price' => 'nullable|numeric|min:0',
            'refunded_amount' => 'nullable|numeric|min:0',
            'excess_amount' => 'nullable|numeric|min:0',
            'group_ids' => 'nullable|array',
            'group_ids.*' => 'exists:groups,id',
            'icon_class' => 'nullable|string|max:255',
            'status' => 'required|boolean',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string'
        ]);

        $extra = VendorExtra::create(array_merge($request->except('features'), ['vendor_id' => $this->vendorId()]));

        if ($request->has('features')) {
            foreach ($request->features as $idx => $feature_title) {
                if (!empty(trim($feature_title))) {
                    $extra->features()->create([
                        'title' => trim($feature_title),
                        'index_no' => $idx
                    ]);
                }
            }
        }

        $route = $request->type === 'extra' ? 'vendor.extras.index' : 'vendor.insurance.index';
        return redirect()->route($route)->with('success', ucfirst($request->type) . ' created successfully.');
    }

    public function updateExtra(Request $request, $id)
    {
        $extra = VendorExtra::where('vendor_id', $this->vendorId())->findOrFail($id);
        
        $request->validate([
            'type' => 'required|in:extra,insurance',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'arrival_price' => 'nullable|numeric|min:0',
            'refunded_amount' => 'nullable|numeric|min:0',
            'excess_amount' => 'nullable|numeric|min:0',
            'group_ids' => 'nullable|array',
            'group_ids.*' => 'exists:groups,id',
            'icon_class' => 'nullable|string|max:255',
            'status' => 'required|boolean',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string'
        ]);

        $extra->update($request->except('features'));

        // Sync features
        $extra->features()->delete();
        if ($request->has('features')) {
            foreach ($request->features as $idx => $feature_title) {
                if (!empty(trim($feature_title))) {
                    $extra->features()->create([
                        'title' => trim($feature_title),
                        'index_no' => $idx
                    ]);
                }
            }
        }

        $route = $request->type === 'extra' ? 'vendor.extras.index' : 'vendor.insurance.index';
        return redirect()->route($route)->with('success', ucfirst($extra->type) . ' updated successfully.');
    }

    public function destroyExtra($id)
    {
        $extra = VendorExtra::where('vendor_id', $this->vendorId())->findOrFail($id);
        $extra->delete();
        return response()->json(['status' => 'success']);
    }

    public function toggleExtraStatus($id)
    {
        $extra = VendorExtra::where('vendor_id', $this->vendorId())->findOrFail($id);
        $extra->update(['status' => !$extra->status]);
        return response()->json(['status' => 'success', 'new_status' => $extra->status]);
    }



    public function featuresIndex(Request $request)
    {
        $vendor_id = $this->vendorId();
        $features = \App\Models\VendorFeature::where('vendor_id', $vendor_id)->orderBy('index_no')->get();
        return view('vendor.extras.features', compact('features'));
    }

    public function updateFeatures(Request $request)
    {
        $vendor_id = $this->vendorId();
        
        \App\Models\VendorFeature::where('vendor_id', $vendor_id)->delete();

        if ($request->has('features') && is_array($request->features)) {
            foreach ($request->features as $featureRow) {
                $title = trim($featureRow['title'] ?? '');
                $index_no = (int)($featureRow['index_no'] ?? 0);

                if (!empty($title)) {
                    \App\Models\VendorFeature::create([
                        'vendor_id' => $vendor_id,
                        'title' => $title,
                        'index_no' => $index_no,
                        'status' => 1
                    ]);
                }
            }
        }

        return redirect()->route('vendor.features.index')->with('success', 'Features updated successfully.');
    }

    // --- Rules ---
    public function storeRule(Request $request)
    {
        $request->validate(['min_age' => 'required|integer', 'max_age' => 'required|integer', 'underage_charge' => 'required|numeric']);
        VendorRule::create(array_merge($request->all(), ['vendor_id' => $this->vendorId()]));
        return response()->json(['status' => 'success']);
    }

    public function updateRule(Request $request, $id)
    {
        $rule = VendorRule::where('vendor_id', $this->vendorId())->findOrFail($id);
        $rule->update($request->all());
        return response()->json(['status' => 'success']);
    }

    public function destroyRule($id)
    {
        $rule = VendorRule::where('vendor_id', $this->vendorId())->findOrFail($id);
        $rule->delete();
        return response()->json(['status' => 'success']);
    }

    public function toggleFeatureMapping(Request $request)
    {
        $request->validate([
            'vendor_extra_id' => 'required|exists:vendor_extras,id',
            'vendor_feature_id' => 'required|exists:vendor_features,id',
            'is_mapped' => 'required|boolean'
        ]);

        $vendor_id = $this->vendorId();
        
        // Ensure both belong to the logged-in vendor
        $extra = VendorExtra::where('vendor_id', $vendor_id)->find($request->vendor_extra_id);
        $feature = \App\Models\VendorFeature::where('vendor_id', $vendor_id)->find($request->vendor_feature_id);

        if (!$extra || !$feature) {
            return response()->json(['success' => false, 'message' => 'Unauthorized or invalid resource.'], 403);
        }

        if ($request->is_mapped) {
            \DB::table('vendor_extra_feature_mappings')->updateOrInsert([
                'vendor_extra_id' => $request->vendor_extra_id,
                'vendor_feature_id' => $request->vendor_feature_id,
            ], [
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $message = 'Feature mapped successfully.';
        } else {
            \DB::table('vendor_extra_feature_mappings')
                ->where('vendor_extra_id', $request->vendor_extra_id)
                ->where('vendor_feature_id', $request->vendor_feature_id)
                ->delete();
            $message = 'Feature unmapped successfully.';
        }

        return response()->json(['success' => true, 'message' => $message]);
    }

    public function updateFeatureSort(Request $request, $id)
    {
        $request->validate([
            'index_no' => 'required|integer|min:1'
        ]);

        $vendor_id = $this->vendorId();
        $feature = \App\Models\VendorFeature::where('vendor_id', $vendor_id)->findOrFail($id);

        $exists = \App\Models\VendorFeature::where('vendor_id', $vendor_id)
            ->where('id', '!=', $id)
            ->where('index_no', $request->index_no)
            ->exists();

        if ($exists) {
            return response()->json(['success' => false, 'message' => 'This sort order is already assigned.'], 422);
        }

        $feature->update(['index_no' => $request->index_no]);

        return response()->json(['success' => true, 'message' => 'Sort order updated successfully.']);
    }
}
