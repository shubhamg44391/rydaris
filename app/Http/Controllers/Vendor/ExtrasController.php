<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\VendorExtra;
use App\Models\VendorExtraFeature;
use App\Models\VendorFeature;
use App\Models\VendorRule;
use Illuminate\Support\Facades\Auth;

class ExtrasController extends Controller
{
    private function vendorId()
    {
        return Auth::id();
    }

    private function getGroups()
    {
        $branchId = auth()->user()->current_branch_id;
        $groupsQuery = Group::where('vendor_id', $this->vendorId());
        if ($branchId) {
            $groupsQuery->where(function ($q) use ($branchId) {
                $q->where('branch_id', $branchId)
                  ->orWhereNull('branch_id');
            });
        }
        return $groupsQuery->orderBy('name')->get();
    }

    public function extrasIndex(Request $request)
    {
        $query = VendorExtra::where('vendor_id', $this->vendorId())->where('type', 'extra');
        
        $branchId = auth()->user()->current_branch_id;
        if ($branchId) {
            $query->where(function ($q) use ($branchId) {
                $q->where('branch_id', $branchId)
                  ->orWhereNull('branch_id');
            });
        }
        
        $extras = $query->get();

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'status' => 'success',
                'html' => view('vendor.extras.extras', compact('extras'))->renderSections()['extras_table_section'] ?? ''
            ]);
        }

        return view('vendor.extras.extras', compact('extras'));
    }

    private function getVendorFeatures()
    {
        $vendor_features = VendorFeature::where('vendor_id', $this->vendorId())->orderBy('index_no')->get();
        
        $hasZeroOrDup = false;
        $seen = [];
        foreach ($vendor_features as $vf) {
            if ($vf->index_no <= 0 || isset($seen[$vf->index_no])) {
                $hasZeroOrDup = true;
                break;
            }
            $seen[$vf->index_no] = true;
        }

        if ($hasZeroOrDup) {
            foreach ($vendor_features as $k => $vf) {
                $vf->index_no = $k + 1;
                $vf->save();
            }
            $vendor_features = VendorFeature::where('vendor_id', $this->vendorId())->orderBy('index_no')->get();
        }

        return $vendor_features;
    }

    public function createExtra()
    {
        if (!Auth::user()->canAddExtra()) {
            return redirect()->route('vendor.extras.index')->with('error', 'You have reached your maximum extras capacity based on your current plan. Upgrade your plan to add more extras.');
        }
        $groups = $this->getGroups();
        $vendor_features = $this->getVendorFeatures();
        $insurances = VendorExtra::where('vendor_id', $this->vendorId())->where('type', 'insurance')->get();
        return view('vendor.extras.create', ['type' => 'extra', 'groups' => $groups, 'vendor_features' => $vendor_features, 'insurances' => $insurances]);
    }

    public function editExtra(Request $request, $id)
    {
        $item = VendorExtra::where('vendor_id', $this->vendorId())->findOrFail($id);

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'status' => 'success',
                'item' => $item
            ]);
        }

        $groups = $this->getGroups();
        $vendor_features = $this->getVendorFeatures();
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
        if (!Auth::user()->canAddInsurance()) {
            return redirect()->route('vendor.insurance.index')->with('error', 'You have reached your maximum insurance capacity based on your current plan. Upgrade your plan to add more insurances.');
        }
        $groups = $this->getGroups();
        $vendor_features = $this->getVendorFeatures();
        $insurances = VendorExtra::where('vendor_id', $this->vendorId())->where('type', 'insurance')->get();
        return view('vendor.extras.create', ['type' => 'insurance', 'groups' => $groups, 'vendor_features' => $vendor_features, 'insurances' => $insurances]);
    }

    public function editInsurance(Request $request, $id)
    {
        $item = VendorExtra::where('vendor_id', $this->vendorId())->findOrFail($id);

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'status' => 'success',
                'item' => $item
            ]);
        }

        $groups = $this->getGroups();
        $vendor_features = $this->getVendorFeatures();
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

    public function insuranceIndex(Request $request)
    {
        $query = VendorExtra::where('vendor_id', $this->vendorId())->where('type', 'insurance');
        
        $branchId = auth()->user()->current_branch_id;
        if ($branchId) {
            $query->where(function ($q) use ($branchId) {
                $q->where('branch_id', $branchId)
                  ->orWhereNull('branch_id');
            });
        }
        
        $insurances = $query->get();

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'status' => 'success',
                'html' => view('vendor.extras.insurance', compact('insurances'))->renderSections()['insurance_table_section'] ?? ''
            ]);
        }

        return view('vendor.extras.insurance', compact('insurances'));
    }

    public function rulesIndex(Request $request)
    {
        $rules = VendorRule::where('vendor_id', $this->vendorId())->get();

        if ($request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'status' => 'success',
                'html' => view('vendor.extras.rules', compact('rules'))->renderSections()['rules_table_section'] ?? ''
            ]);
        }

        return view('vendor.extras.rules', compact('rules'));
    }

    public function storeExtra(Request $request)
    {
        $isAjax = $request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest';

        $type = $request->input('type', 'extra');
        if ($type === 'extra' && !Auth::user()->canAddExtra()) {
            $msg = 'You have reached your maximum extra item capacity based on your current plan. Upgrade your plan to add more extras.';
            if ($isAjax) {
                return response()->json(['status' => 'error', 'message' => $msg], 422);
            }
            return back()->withInput()->withErrors(['name' => $msg]);
        }
        if ($type === 'insurance' && !Auth::user()->canAddInsurance()) {
            $msg = 'You have reached your maximum insurance item capacity based on your current plan. Upgrade your plan to add more insurances.';
            if ($isAjax) {
                return response()->json(['status' => 'error', 'message' => $msg], 422);
            }
            return back()->withInput()->withErrors(['name' => $msg]);
        }

        try {
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
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($isAjax) {
                return response()->json([
                    'status' => 'error',
                    'message' => collect($e->errors())->first()[0] ?? 'Validation failed.'
                ], 422);
            }
            throw $e;
        }

        $extra = VendorExtra::create(array_merge($request->except('features'), [
            'vendor_id' => $this->vendorId(),
            'branch_id' => auth()->user()->current_branch_id,
        ]));

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

        if ($isAjax) {
            return response()->json([
                'status' => 'success',
                'message' => ucfirst($request->type) . ' created successfully.'
            ]);
        }

        $route = $request->type === 'extra' ? 'vendor.extras.index' : 'vendor.insurance.index';
        return redirect()->route($route)->with('success', ucfirst($request->type) . ' created successfully.');
    }

    public function updateExtra(Request $request, $id)
    {
        $isAjax = $request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest';

        $extra = VendorExtra::where('vendor_id', $this->vendorId())->findOrFail($id);
        
        try {
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
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($isAjax) {
                return response()->json([
                    'status' => 'error',
                    'message' => collect($e->errors())->first()[0] ?? 'Validation failed.'
                ], 422);
            }
            throw $e;
        }

        $extra->update($request->except('features'));

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

        if ($isAjax) {
            return response()->json([
                'status' => 'success',
                'message' => ucfirst($extra->type) . ' updated successfully.'
            ]);
        }

        $route = $request->type === 'extra' ? 'vendor.extras.index' : 'vendor.insurance.index';
        return redirect()->route($route)->with('success', ucfirst($extra->type) . ' updated successfully.');
    }

    public function destroyExtra($id)
    {
        $extra = VendorExtra::where('vendor_id', $this->vendorId())->findOrFail($id);
        $extra->delete();
        return response()->json(['status' => 'success', 'message' => 'Item deleted successfully.']);
    }

    public function toggleExtraStatus($id)
    {
        $extra = VendorExtra::where('vendor_id', $this->vendorId())->findOrFail($id);
        $extra->update(['status' => !$extra->status]);
        return response()->json(['status' => 'success', 'new_status' => $extra->status]);
    }

    public function featuresIndex(Request $request)
    {
        $features = $this->getVendorFeatures();
        return view('vendor.extras.features', compact('features'));
    }

    public function updateFeatures(Request $request)
    {
        $isAjax = $request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest';
        $vendor_id = $this->vendorId();
        
        $featuresCount = 0;
        if ($request->has('features') && is_array($request->features)) {
            foreach ($request->features as $featureRow) {
                if (!empty(trim($featureRow['title'] ?? ''))) {
                    $featuresCount++;
                }
            }
        }
        
        if (!Auth::user()->canAddFeature($featuresCount)) {
            $msg = 'You have reached your maximum features capacity based on your current plan. Upgrade your plan to add more features.';
            if ($isAjax) {
                return response()->json(['status' => 'error', 'message' => $msg], 422);
            }
            return back()->withErrors(['features' => $msg]);
        }

        VendorFeature::where('vendor_id', $vendor_id)->delete();

        if ($request->has('features') && is_array($request->features)) {
            $idx = 1;
            foreach ($request->features as $featureRow) {
                $title = trim($featureRow['title'] ?? '');
                $index_no = (int)($featureRow['index_no'] ?? $idx);
                if ($index_no <= 0) {
                    $index_no = $idx;
                }

                if (!empty($title)) {
                    VendorFeature::create([
                        'vendor_id' => $vendor_id,
                        'title' => $title,
                        'index_no' => $index_no,
                        'status' => 1
                    ]);
                    $idx++;
                }
            }
        }

        if ($isAjax) {
            return response()->json([
                'status' => 'success',
                'message' => 'Features updated successfully.'
            ]);
        }

        return redirect()->route('vendor.features.index')->with('success', 'Features updated successfully.');
    }

    public function storeRule(Request $request)
    {
        if (!Auth::user()->canAddRule()) {
            return response()->json(['status' => 'error', 'message' => 'You have reached your maximum rules capacity based on your current plan.'], 422);
        }

        try {
            $request->validate([
                'min_age' => 'required|integer|min:0',
                'max_age' => 'required|integer|gte:min_age',
                'underage_charge' => 'required|numeric|min:0'
            ], [
                'max_age.gte' => 'Max age must be greater than or equal to Min age.'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => collect($e->errors())->first()[0] ?? 'Validation failed.'
            ], 422);
        }

        VendorRule::create(array_merge($request->all(), ['vendor_id' => $this->vendorId()]));
        return response()->json(['status' => 'success', 'message' => 'Rule created successfully.']);
    }

    public function updateRule(Request $request, $id)
    {
        $rule = VendorRule::where('vendor_id', $this->vendorId())->findOrFail($id);

        try {
            $request->validate([
                'min_age' => 'required|integer|min:0',
                'max_age' => 'required|integer|gte:min_age',
                'underage_charge' => 'required|numeric|min:0'
            ], [
                'max_age.gte' => 'Max age must be greater than or equal to Min age.'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => collect($e->errors())->first()[0] ?? 'Validation failed.'
            ], 422);
        }

        $rule->update($request->all());
        return response()->json(['status' => 'success', 'message' => 'Rule updated successfully.']);
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
        
        
        $extra = VendorExtra::where('vendor_id', $vendor_id)->find($request->vendor_extra_id);
        $feature = VendorFeature::where('vendor_id', $vendor_id)->find($request->vendor_feature_id);

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
        $feature = VendorFeature::where('vendor_id', $vendor_id)->findOrFail($id);

        $exists = VendorFeature::where('vendor_id', $vendor_id)
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
