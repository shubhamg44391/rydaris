<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Availability;
use App\Models\VehicleAvailability;
use App\Models\RentalPeriod;
use App\Models\Group;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\VendorRateHistory;
use Illuminate\Support\Facades\Response;

class AvailabilityController extends Controller
{
    private function vendorId(): int
    {
        return Auth::id();
    }

    /* ---------------------------------------------------------------
     | 1. INDEX — main pricing management view
     --------------------------------------------------------------- */
    public function index()
    {
        $vid = $this->vendorId();
        $groups  = Group::where('vendor_id', $vid)->orderBy('name')->get();
        $periods = RentalPeriod::where('vendor_id', $vid)->orderBy('min_day')->get();

        $initialData = $this->getRatesMatrixData($vid, now()->year, 'next30', null, null, []);

        return view('vendor.availability.index', compact('groups', 'periods', 'initialData'));
    }

    /* ---------------------------------------------------------------
     | 2. CREATE — add rate form
     --------------------------------------------------------------- */
    public function create()
    {
        $groups   = Group::where('vendor_id', $this->vendorId())->orderBy('name')->get();
        $vehicles = Vehicle::where('vendor_id', $this->vendorId())->where('status', 'active')->orderBy('name')->get();
        $periods  = RentalPeriod::where('vendor_id', $this->vendorId())->orderBy('min_day')->get();

        return view('vendor.availability.create', compact('groups', 'vehicles', 'periods'));
    }

    /* ---------------------------------------------------------------
     | 3. STORE — save new rate
     --------------------------------------------------------------- */
    public function store(Request $request)
    {
        $request->validate([
            'group_id'         => ['required', 'exists:groups,id'],
            'vehicle_id'       => ['nullable', 'exists:vehicles,id'],
            'rental_period_id' => ['nullable', 'exists:rental_periods,id'],
            'pickup_date'      => ['required', 'date'],
            'dropup_date'      => ['required', 'date', 'after_or_equal:pickup_date'],
            'min_day'          => ['required', 'integer', 'min:1'],
            'max_day'          => ['required', 'integer', 'gte:min_day'],
            'price'            => ['required', 'numeric', 'min:0'],
            'status'           => ['required', 'in:1,0'],
        ]);

        Availability::create([
            'vendor_id'        => $this->vendorId(),
            'group_id'         => $request->group_id,
            'vehicle_id'       => $request->vehicle_id,
            'rental_period_id' => $request->rental_period_id,
            'pickup_date'      => $request->pickup_date,
            'dropup_date'      => $request->dropup_date,
            'min_day'          => $request->min_day,
            'max_day'          => $request->max_day,
            'price'            => $request->price,
            'status'           => $request->status,
        ]);

        return redirect(route('vendor.availability.index'))
            ->with('success', 'Rate added successfully.');
    }

    /* ---------------------------------------------------------------
     | 4. EDIT — load edit form
     --------------------------------------------------------------- */
    public function edit($id)
    {
        $availability = Availability::where('vendor_id', $this->vendorId())->findOrFail($id);
        $groups       = Group::where('vendor_id', $this->vendorId())->orderBy('name')->get();
        $vehicles     = Vehicle::where('vendor_id', $this->vendorId())->where('status', 'active')->orderBy('name')->get();
        $periods      = RentalPeriod::where('vendor_id', $this->vendorId())->orderBy('min_day')->get();

        return view('vendor.availability.edit', compact('availability', 'groups', 'vehicles', 'periods'));
    }

    /* ---------------------------------------------------------------
     | 5. UPDATE — save edited rate
     --------------------------------------------------------------- */
    public function update(Request $request, $id)
    {
        $availability = Availability::where('vendor_id', $this->vendorId())->findOrFail($id);

        $request->validate([
            'group_id'         => ['required', 'exists:groups,id'],
            'vehicle_id'       => ['nullable', 'exists:vehicles,id'],
            'rental_period_id' => ['nullable', 'exists:rental_periods,id'],
            'pickup_date'      => ['required', 'date'],
            'dropup_date'      => ['required', 'date', 'after_or_equal:pickup_date'],
            'min_day'          => ['required', 'integer', 'min:1'],
            'max_day'          => ['required', 'integer', 'gte:min_day'],
            'price'            => ['required', 'numeric', 'min:0'],
            'status'           => ['required', 'in:1,0'],
        ]);

        $availability->update([
            'group_id'         => $request->group_id,
            'vehicle_id'       => $request->vehicle_id,
            'rental_period_id' => $request->rental_period_id,
            'pickup_date'      => $request->pickup_date,
            'dropup_date'      => $request->dropup_date,
            'min_day'          => $request->min_day,
            'max_day'          => $request->max_day,
            'price'            => $request->price,
            'status'           => $request->status,
        ]);

        return redirect(route('vendor.availability.index'))
            ->with('success', 'Rate updated successfully.');
    }

    /* ---------------------------------------------------------------
     | 6. DESTROY — delete rate
     --------------------------------------------------------------- */
    public function destroy($id)
    {
        $availability = Availability::where('vendor_id', $this->vendorId())->findOrFail($id);
        $availability->delete();

        return redirect(route('vendor.availability.index'))
            ->with('success', 'Rate deleted successfully.');
    }

    /* ---------------------------------------------------------------
     | 7. TOGGLE STATUS — AJAX
     --------------------------------------------------------------- */
    public function toggleStatus(Request $request, $id)
    {
        $availability = Availability::where('vendor_id', $this->vendorId())->findOrFail($id);
        $availability->update(['status' => $availability->status ? 0 : 1]);

        return response()->json(['status' => $availability->status]);
    }

    /* ---------------------------------------------------------------
     | 8. FETCH RATES — AJAX → returns matrix JSON for table
     --------------------------------------------------------------- */
    public function fetchRates(Request $request)
    {
        $vid       = $this->vendorId();
        $year      = $request->input('year', now()->year);
        $month     = $request->input('month');
        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');
        $groupIds  = $request->input('group_ids', []);

        $result = $this->getRatesMatrixData($vid, $year, $month, $startDate, $endDate, $groupIds);

        return response()->json(array_merge(['status' => 'success'], $result));
    }

    private function getRatesMatrixData($vid, $year, $month, $startDate, $endDate, $groupIds)
    {
        // Determine date range
        if ($startDate && $endDate) {
            $from = Carbon::parse($startDate)->startOfDay();
            $to   = Carbon::parse($endDate)->endOfDay();
        } elseif ($month === 'next30') {
            $from = now()->startOfDay();
            $to   = now()->addDays(29)->endOfDay();
        } elseif ($month) {
            $from = Carbon::create($year, $month, 1)->startOfMonth();
            $to   = Carbon::create($year, $month, 1)->endOfMonth();
        } else {
            $from = now()->startOfMonth();
            $to   = now()->endOfMonth();
        }

        $groups = Group::where('vendor_id', $vid)->orderBy('name');
        if (!empty($groupIds)) {
            $groups->whereIn('id', $groupIds);
        }
        $groups = $groups->with(['vehicles' => function ($q) use ($vid) {
            $q->where('vendor_id', $vid)->where('status', 'active');
        }])->get();

        // Fetch all group-level rates in range
        $rates = Availability::where('vendor_id', $vid)
            ->where('status', 1)
            ->where('pickup_date', '<=', $to->toDateString())
            ->where('dropup_date', '>=', $from->toDateString())
            ->when(!empty($groupIds), fn($q) => $q->whereIn('group_id', $groupIds))
            ->orderBy('id', 'asc')
            ->get();

        // Fetch vehicle-level overrides
        $vehicleIds = $groups->pluck('vehicles')->flatten()->pluck('id')->unique()->values();
        $vRates = VehicleAvailability::where('vendor_id', $vid)
            ->where('status', 1)
            ->where('pickup_date', '<=', $to->toDateString())
            ->where('dropup_date', '>=', $from->toDateString())
            ->whereIn('vehicle_id', $vehicleIds)
            ->orderBy('id', 'asc')
            ->get();

        // Build date list
        $dates = [];
        $period = CarbonPeriod::create($from, $to);
        foreach ($period as $date) {
            $dates[] = $date->toDateString();
        }

        // Pre-build index for O(1) lookups: $groupRatesLookup[group_id][date_string]
        $groupRatesLookup = [];
        foreach ($rates as $r) {
            $pStr = is_object($r->pickup_date) ? $r->pickup_date->toDateString() : $r->pickup_date;
            $dStr = is_object($r->dropup_date) ? $r->dropup_date->toDateString() : $r->dropup_date;
            $subPeriod = CarbonPeriod::create($pStr, $dStr);
            foreach ($subPeriod as $d) {
                $ds = $d->toDateString();
                $groupRatesLookup[$r->group_id][$ds][] = $r;
            }
        }

        // Pre-build index for vehicle overrides: $vehRatesLookup[vehicle_id][date_string]
        $vehRatesLookup = [];
        foreach ($vRates as $r) {
            $pStr = is_object($r->pickup_date) ? $r->pickup_date->toDateString() : $r->pickup_date;
            $dStr = is_object($r->dropup_date) ? $r->dropup_date->toDateString() : $r->dropup_date;
            $subPeriod = CarbonPeriod::create($pStr, $dStr);
            foreach ($subPeriod as $d) {
                $ds = $d->toDateString();
                $vehRatesLookup[$r->vehicle_id][$ds][] = $r;
            }
        }

        $matrix = [];

        foreach ($groups as $group) {
            $matrix[$group->id] = [
                'name'     => $group->name,
                'dates'    => [],
                'vehicles' => [],
            ];

            foreach ($dates as $date) {
                $dayRates = [];
                $matching = $groupRatesLookup[$group->id][$date] ?? [];
                
                foreach ($matching as $r) {
                    for ($d = $r->min_day; $d <= $r->max_day; $d++) {
                        $dayRates[$d] = [
                            'price' => (float) $r->price,
                            'id'    => $r->id,
                            'pid'   => $r->rental_period_id,
                        ];
                    }
                }
                $matrix[$group->id]['dates'][$date] = $dayRates;
            }

            foreach ($group->vehicles as $vehicle) {
                $matrix[$group->id]['vehicles'][$vehicle->id] = [
                    'name'  => $vehicle->name,
                    'code'  => $vehicle->code,
                    'dates' => [],
                ];

                foreach ($dates as $date) {
                    $dayRates = [];
                    $vMatchGroup = $groupRatesLookup[$group->id][$date] ?? [];
                    $vMatchVehicle = $vehRatesLookup[$vehicle->id][$date] ?? [];

                    // Group rates as base
                    foreach ($vMatchGroup as $r) {
                        for ($d = $r->min_day; $d <= $r->max_day; $d++) {
                            $dayRates[$d] = ['price' => (float) $r->price, 'id' => $r->id, 'pid' => $r->rental_period_id, 'source' => 'group'];
                        }
                    }
                    // Vehicle overrides
                    foreach ($vMatchVehicle as $r) {
                        for ($d = $r->min_day; $d <= $r->max_day; $d++) {
                            $dayRates[$d] = ['price' => (float) $r->price, 'id' => $r->id, 'pid' => $r->rental_period_id, 'source' => 'vehicle'];
                        }
                    }

                    $matrix[$group->id]['vehicles'][$vehicle->id]['dates'][$date] = $dayRates;
                }
            }
        }

        return ['data' => $matrix, 'dates' => $dates];
    }

    /* ---------------------------------------------------------------
     | 9. UPDATE SINGLE RATE — AJAX inline cell edit
     --------------------------------------------------------------- */
    public function updateSingleRate(Request $request)
    {
        $request->validate([
            'date'     => ['required', 'date'],
            'day'      => ['required', 'integer', 'min:1'],
            'price'    => ['required', 'numeric', 'min:0'],
            'group_id' => ['required', 'exists:groups,id'],
            'vehicle_id' => ['nullable', 'exists:vehicles,id'],
        ]);

        $vid     = $this->vendorId();
        $date    = $request->date;
        $day     = (int) $request->day;
        $price   = (float) $request->price;
        $groupId = (int) $request->group_id;
        $vehicleId = $request->vehicle_id ? (int) $request->vehicle_id : null;

        if ($vehicleId) {
            // 1. Delete previous EXACT single-day override for this vehicle date
            VehicleAvailability::where('vendor_id', $vid)
                ->where('vehicle_id', $vehicleId)
                ->where('pickup_date', $date)
                ->where('dropup_date', $date)
                ->where('min_day', $day)
                ->where('max_day', $day)
                ->delete();

            // 2. Insert new exact override
            VehicleAvailability::create([
                'vendor_id'   => $vid,
                'vehicle_id'  => $vehicleId,
                'pickup_date' => $date,
                'dropup_date' => $date,
                'min_day'     => $day,
                'max_day'     => $day,
                'price'       => $price,
                'status'      => 1,
            ]);
        } else {
            // 1. Delete previous EXACT single-day override for this group date
            Availability::where('vendor_id', $vid)
                ->where('group_id', $groupId)
                ->whereNull('vehicle_id')
                ->where('pickup_date', $date)
                ->where('dropup_date', $date)
                ->where('min_day', $day)
                ->where('max_day', $day)
                ->delete();

            // 2. Insert new exact override
            Availability::create([
                'vendor_id'   => $vid,
                'group_id'    => $groupId,
                'vehicle_id'  => null,
                'pickup_date' => $date,
                'dropup_date' => $date,
                'min_day'     => $day,
                'max_day'     => $day,
                'price'       => $price,
                'status'      => 1,
            ]);
        }

        \App\Models\VendorRateHistory::create([
            'vendor_id' => $vid,
            'action_type' => 'single_update',
            'details' => json_encode(['date' => $date, 'day' => $day, 'price' => $price])
        ]);

        return response()->json(['status' => 'success', 'day' => $day, 'price' => $price]);
    }

    /* ---------------------------------------------------------------
     | 10. BULK COPY DAY 1 RATES TO ALL DAYS (2-31)
     --------------------------------------------------------------- */
    public function bulkCopyDay1(Request $request)
    {
        $request->validate([
            'updates' => ['required', 'array'],
            'updates.*.date' => ['required', 'date'],
            'updates.*.price' => ['required', 'numeric', 'min:0'],
            'updates.*.group_id' => ['required', 'exists:groups,id'],
            'updates.*.vehicle_id' => ['nullable', 'exists:vehicles,id'],
        ]);

        $vid = $this->vendorId();
        $updates = $request->updates;
        $now = now();
        
        $insertDataAvail = [];
        $insertDataVeh = [];
        
        foreach ($updates as $u) {
            $date = $u['date'];
            $price = (float) $u['price'];
            $groupId = (int) $u['group_id'];
            $vehicleId = $u['vehicle_id'] ? (int) $u['vehicle_id'] : null;
            
            if ($vehicleId) {
                // Delete existing for this specific date and vehicle
                VehicleAvailability::where('vendor_id', $vid)
                    ->where('vehicle_id', $vehicleId)
                    ->where('pickup_date', $date)
                    ->where('dropup_date', $date)
                    ->whereBetween('min_day', [2, 31])
                    ->whereRaw('min_day = max_day')
                    ->delete();
                    
                for ($day = 2; $day <= 31; $day++) {
                    $insertDataVeh[] = [
                        'vendor_id'   => $vid,
                        'vehicle_id'  => $vehicleId,
                        'pickup_date' => $date,
                        'dropup_date' => $date,
                        'min_day'     => $day,
                        'max_day'     => $day,
                        'price'       => $price,
                        'status'      => 1,
                        'created_at'  => $now,
                        'updated_at'  => $now,
                    ];
                }
            } else {
                // Delete existing for this specific date and group
                Availability::where('vendor_id', $vid)
                    ->where('group_id', $groupId)
                    ->whereNull('vehicle_id')
                    ->where('pickup_date', $date)
                    ->where('dropup_date', $date)
                    ->whereBetween('min_day', [2, 31])
                    ->whereRaw('min_day = max_day')
                    ->delete();
                    
                for ($day = 2; $day <= 31; $day++) {
                    $insertDataAvail[] = [
                        'vendor_id'   => $vid,
                        'group_id'    => $groupId,
                        'vehicle_id'  => null,
                        'pickup_date' => $date,
                        'dropup_date' => $date,
                        'min_day'     => $day,
                        'max_day'     => $day,
                        'price'       => $price,
                        'status'      => 1,
                        'created_at'  => $now,
                        'updated_at'  => $now,
                    ];
                }
            }
        }
        
        if (!empty($insertDataVeh)) {
            $chunks = array_chunk($insertDataVeh, 500);
            foreach($chunks as $chunk) { VehicleAvailability::insert($chunk); }
        }
        
        if (!empty($insertDataAvail)) {
            $chunks = array_chunk($insertDataAvail, 500);
            foreach($chunks as $chunk) { Availability::insert($chunk); }
        }

        \App\Models\VendorRateHistory::create([
            'vendor_id' => $vid,
            'action_type' => 'bulk_copy',
            'details' => json_encode(['copied_from_day1' => count($updates)])
        ]);

        return response()->json(['status' => 'success']);
    }

    /* ---------------------------------------------------------------
     | 10. BULK UPDATE RATES — AJAX
     --------------------------------------------------------------- */
    public function bulkUpdateRates(Request $request)
    {
        $request->validate([
            'from_date' => ['required', 'date'],
            'to_date'   => ['required', 'date', 'after_or_equal:from_date'],
            'operation' => ['required', 'string'],
            'group_ids' => ['required', 'array'],
            'days'      => ['required', 'array'],
        ]);

        $vid       = $this->vendorId();
        $fromDate  = Carbon::parse($request->from_date);
        $toDate    = Carbon::parse($request->to_date);
        $operation = trim($request->operation);
        $groupIds  = $request->group_ids;
        $days      = array_map('intval', $request->days);
        $vehicleId = $request->input('vehicle_id');

        $period = CarbonPeriod::create($fromDate, $toDate);
        $dateStrings = [];
        foreach ($period as $date) {
            $dateStrings[] = $date->toDateString();
        }

        // 1. Fetch existing records BEFORE deleting so we can calculate overrides
        if ($vehicleId) {
            $existingRecords = VehicleAvailability::where('vendor_id', $vid)
                ->where('vehicle_id', $vehicleId)
                ->where('pickup_date', '<=', $toDate->toDateString())
                ->where('dropup_date', '>=', $fromDate->toDateString())
                ->get();

            // 2. Delete previous exact single-day overrides for the selected combination
            VehicleAvailability::where('vendor_id', $vid)
                ->where('vehicle_id', $vehicleId)
                ->whereIn('pickup_date', $dateStrings)
                ->whereIn('dropup_date', $dateStrings)
                ->whereRaw('pickup_date = dropup_date')
                ->whereIn('min_day', $days)
                ->whereRaw('min_day = max_day')
                ->delete();
        } else {
            $existingRecords = Availability::where('vendor_id', $vid)
                ->whereIn('group_id', $groupIds)
                ->whereNull('vehicle_id')
                ->where('pickup_date', '<=', $toDate->toDateString())
                ->where('dropup_date', '>=', $fromDate->toDateString())
                ->get();

            // 2. Delete previous exact single-day overrides for the selected combination
            Availability::where('vendor_id', $vid)
                ->whereIn('group_id', $groupIds)
                ->whereNull('vehicle_id')
                ->whereIn('pickup_date', $dateStrings)
                ->whereIn('dropup_date', $dateStrings)
                ->whereRaw('pickup_date = dropup_date')
                ->whereIn('min_day', $days)
                ->whereRaw('min_day = max_day')
                ->delete();
        }

        // Pre-build index for O(1) lookup
        $lookup = [];
        foreach ($existingRecords as $rec) {
            $pStr = is_object($rec->pickup_date) ? $rec->pickup_date->toDateString() : $rec->pickup_date;
            $dStr = is_object($rec->dropup_date) ? $rec->dropup_date->toDateString() : $rec->dropup_date;
            $subPeriod = CarbonPeriod::create($pStr, $dStr);
            
            $key = $vehicleId ? $rec->vehicle_id : $rec->group_id;

            foreach ($subPeriod as $d) {
                $ds = $d->toDateString();
                $lookup[$key][$ds][] = $rec;
            }
        }

        $insertData = [];
        $now = now();

        foreach ($dateStrings as $dateStr) {
            $keys = $vehicleId ? [$vehicleId] : $groupIds;
            foreach ($keys as $keyVal) {
                // Find records covering this specific date in O(1) time
                $matching = $lookup[$keyVal][$dateStr] ?? [];
                
                foreach ($days as $day) {
                    $found = false;
                    foreach ($matching as $rec) {
                        if ($day >= $rec->min_day && $day <= $rec->max_day) {
                            $found = true;
                            $newPrice = $this->applyOperation((float)$rec->price, $operation);
                            
                            $row = [
                                'vendor_id'   => $vid,
                                'pickup_date' => $dateStr,
                                'dropup_date' => $dateStr,
                                'min_day'     => $day,
                                'max_day'     => $day,
                                'price'       => $newPrice,
                                'status'      => 1,
                                'created_at'  => $now,
                                'updated_at'  => $now,
                            ];
                            
                            if ($vehicleId) {
                                $row['vehicle_id'] = $keyVal;
                            } else {
                                $row['group_id'] = $keyVal;
                                $row['vehicle_id'] = null;
                            }
                            
                            $insertData[] = $row;
                            break;
                        }
                    }
                    
                    if (!$found) {
                        $newPrice = $this->applyOperation(0.0, $operation);
                        
                        $row = [
                            'vendor_id'   => $vid,
                            'pickup_date' => $dateStr,
                            'dropup_date' => $dateStr,
                            'min_day'     => $day,
                            'max_day'     => $day,
                            'price'       => $newPrice,
                            'status'      => 1,
                            'created_at'  => $now,
                            'updated_at'  => $now,
                        ];
                        
                        if ($vehicleId) {
                            $row['vehicle_id'] = $keyVal;
                        } else {
                            $row['group_id'] = $keyVal;
                            $row['vehicle_id'] = null;
                        }
                        
                        $insertData[] = $row;
                    }
                }
            }
        }

        // Bulk insert in chunks for massive speed improvement
        foreach (array_chunk($insertData, 500) as $chunk) {
            if ($vehicleId) {
                VehicleAvailability::insert($chunk);
            } else {
                Availability::insert($chunk);
            }
        }

        \App\Models\VendorRateHistory::create([
            'vendor_id' => $vid,
            'action_type' => 'bulk_update',
            'details' => json_encode(['operation' => $operation, 'days' => count($days)])
        ]);

        $result = $this->getRatesMatrixData(
            $vid, 
            $request->input('view_year', now()->year), 
            $request->input('view_month', 'next30'), 
            null, 
            null, 
            $request->input('view_groups', [])
        );

        return response()->json(array_merge(['status' => 'success'], $result));
    }

    /* ---------------------------------------------------------------
     | 11. BULK IMPORT RATES — AJAX
     --------------------------------------------------------------- */
    public function bulkImportRates(Request $request)
    {
        $request->validate([
            'rates' => ['required', 'string'],
        ]);

        $vid   = $this->vendorId();
        $rates = json_decode($request->rates, true);

        if (!is_array($rates)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid JSON']);
        }

        foreach ($rates as $row) {
            if (empty($row['group_id']) || empty($row['date']) || !isset($row['day']) || !isset($row['price'])) {
                continue;
            }
            Availability::updateOrCreate(
                [
                    'vendor_id'  => $vid,
                    'group_id'   => $row['group_id'],
                    'vehicle_id' => null,
                    'pickup_date' => $row['date'],
                    'dropup_date' => $row['date'],
                    'min_day'    => $row['day'],
                    'max_day'    => $row['day'],
                ],
                ['price' => $row['price'], 'status' => 1]
            );
        }

        \App\Models\VendorRateHistory::create([
            'vendor_id' => $vid,
            'action_type' => 'import',
            'details' => json_encode(['imported_count' => count($rates)])
        ]);

        return response()->json(['status' => 'success', 'imported' => count($rates)]);
    }

    /* ---------------------------------------------------------------
     | 12. EXPORT RATES — CSV
     --------------------------------------------------------------- */
    public function exportRates(Request $request)
    {
        $vid = $this->vendorId();
        
        $year      = $request->input('year', now()->year);
        $month     = $request->input('month', 'next30');
        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');
        $groupIds  = $request->input('group_ids', []);

        $matrixResult = $this->getRatesMatrixData($vid, $year, $month, $startDate, $endDate, $groupIds);
        $matrix = $matrixResult['data'];
        $dates = $matrixResult['dates'];
        
        \App\Models\VendorRateHistory::create([
            'vendor_id' => $vid,
            'action_type' => 'export',
            'details' => json_encode(['exported_dates' => count($dates)])
        ]);

        $csvFileName = 'rates_export_' . now()->format('Ymd_His') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        return response()->stream(function () use ($matrix, $dates) {
            $handle = fopen('php://output', 'w');
            
            // Header row
            $headerRow = ['Pickup Date', 'ACRISS / VEHICLE'];
            for ($i = 1; $i <= 31; $i++) {
                $headerRow[] = "Day $i";
            }
            fputcsv($handle, $headerRow);
            
            foreach ($dates as $date) {
                foreach ($matrix as $gid => $group) {
                    $groupRates = $group['dates'][$date] ?? [];
                    $gRow = [$date, '[G] ' . $group['name'] . ' (ID:' . $gid . ')'];
                    for ($i = 1; $i <= 31; $i++) {
                        $gRow[] = isset($groupRates[$i]) ? $groupRates[$i]['price'] : 0;
                    }
                    fputcsv($handle, $gRow);
                    
                    foreach ($group['vehicles'] as $vehId => $vehicle) {
                        $vRates = $vehicle['dates'][$date] ?? [];
                        $vRow = [$date, '• ' . $vehicle['name'] . ' (ID:' . $vehId . ')'];
                        for ($i = 1; $i <= 31; $i++) {
                            $vRow[] = isset($vRates[$i]) ? $vRates[$i]['price'] : 0;
                        }
                        fputcsv($handle, $vRow);
                    }
                }
            }
            fclose($handle);
        }, 200, $headers);
    }

    /* ---------------------------------------------------------------
     | 13. IMPORT RATES FROM CSV (FormData)
     --------------------------------------------------------------- */
    public function importRatesCSV(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt'
        ]);

        $vid = $this->vendorId();
        $file = $request->file('csv_file');
        
        $groups = Group::where('vendor_id', $vid)->get()->keyBy('name');
        $vehicles = Vehicle::where('vendor_id', $vid)->get()->keyBy('name');
        
        $handle = fopen($file->getRealPath(), "r");
        $header = fgetcsv($handle); // Skip header
        
        $importedCount = 0;
        $currentDate = null;
        $insertData = [];

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) < 33) continue;
            
            $dateCol = trim($row[0]);
            if (!empty($dateCol)) {
                $currentDate = $dateCol;
            }
            if (!$currentDate) continue;
            
            $nameCol = trim($row[1]);
            $isGroup = str_contains($nameCol, '[G]');
            $isVehicle = !$isGroup;
            
            $groupId = null;
            $vehicleId = null;
            
            // Extract ID if present (highly robust)
            if (preg_match('/\(ID:(\d+)\)/', $nameCol, $matches)) {
                $id = (int)$matches[1];
                if ($isGroup) {
                    $groupId = $id;
                } else {
                    $vehicleId = $id;
                }
            } else {
                // Fallback to name matching (for older exports)
                // Remove [G] and leading non-alphanumeric chars (like mangled bullets from Excel)
                $cleanName = trim(str_replace(['[G]', '•'], '', $nameCol));
                $cleanName = trim(preg_replace('/^[^a-zA-Z0-9]+/', '', $cleanName));
                
                if ($isGroup) {
                    // Try to find group by name
                    $matchedGroup = $groups->first(function($g) use ($cleanName) {
                        return str_contains($g->name, $cleanName) || str_contains($cleanName, $g->name);
                    });
                    if ($matchedGroup) $groupId = $matchedGroup->id;
                } elseif ($isVehicle) {
                    // Try to find vehicle by name
                    $matchedVeh = $vehicles->first(function($v) use ($cleanName) {
                        return str_contains($v->name, $cleanName) || str_contains($cleanName, $v->name);
                    });
                    if ($matchedVeh) $vehicleId = $matchedVeh->id;
                }
            }
            
            if (!$groupId && !$vehicleId) continue;
            
            for ($day = 1; $day <= 31; $day++) {
                $price = floatval($row[$day + 1]);
                if ($price > 0) {
                    $insertData[] = [
                        'vendor_id'   => $vid,
                        'group_id'    => $groupId,
                        'vehicle_id'  => $vehicleId,
                        'pickup_date' => $currentDate,
                        'dropup_date' => $currentDate,
                        'min_day'     => $day,
                        'max_day'     => $day,
                        'price'       => $price,
                        'status'      => 1,
                    ];
                    $importedCount++;
                }
            }
        }
        fclose($handle);

        foreach ($insertData as $data) {
            if ($data['vehicle_id']) {
                VehicleAvailability::updateOrCreate(
                    [
                        'vendor_id'   => $data['vendor_id'],
                        'vehicle_id'  => $data['vehicle_id'],
                        'pickup_date' => $data['pickup_date'],
                        'dropup_date' => $data['dropup_date'],
                        'min_day'     => $data['min_day'],
                        'max_day'     => $data['max_day'],
                    ],
                    [
                        'price'  => $data['price'],
                        'status' => 1
                    ]
                );
            } else {
                Availability::updateOrCreate(
                    [
                        'vendor_id'   => $data['vendor_id'],
                        'group_id'    => $data['group_id'],
                        'vehicle_id'  => null,
                        'pickup_date' => $data['pickup_date'],
                        'dropup_date' => $data['dropup_date'],
                        'min_day'     => $data['min_day'],
                        'max_day'     => $data['max_day'],
                    ],
                    [
                        'price'  => $data['price'],
                        'status' => 1
                    ]
                );
            }
        }

        \App\Models\VendorRateHistory::create([
            'vendor_id' => $vid,
            'action_type' => 'import_csv',
            'details' => json_encode(['imported_rates' => $importedCount])
        ]);

        return response()->json(['status' => 'success', 'imported' => $importedCount]);
    }

    /* ---------------------------------------------------------------
     | 14. FETCH HISTORY
     --------------------------------------------------------------- */
    public function getHistory()
    {
        $history = VendorRateHistory::where('vendor_id', $this->vendorId())
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();
            
        return response()->json(['status' => 'success', 'history' => $history]);
    }

    /* ---------------------------------------------------------------
     | RENTAL PERIODS — CRUD helpers (simple sub-resource)
     --------------------------------------------------------------- */
    public function periodsIndex()
    {
        $periods = RentalPeriod::where('vendor_id', $this->vendorId())->orderBy('min_day')->get();
        return view('vendor.availability.periods', compact('periods'));
    }

    public function periodStore(Request $request)
    {
        $request->validate([
            'min_day' => ['required', 'integer', 'min:1'],
            'max_day' => ['required', 'integer', 'gte:min_day'],
            'label'   => ['nullable', 'string', 'max:100'],
        ]);

        RentalPeriod::create([
            'vendor_id' => $this->vendorId(),
            'min_day'   => $request->min_day,
            'max_day'   => $request->max_day,
            'label'     => $request->label,
        ]);

        return redirect(route('vendor.availability.periods'))->with('success', 'Rental period saved.');
    }

    public function periodDestroy($id)
    {
        RentalPeriod::where('vendor_id', $this->vendorId())->findOrFail($id)->delete();
        return redirect(route('vendor.availability.periods'))->with('success', 'Period deleted.');
    }

    /* ---------------------------------------------------------------
     | PRIVATE HELPERS
     --------------------------------------------------------------- */
    private function applyOperation(float $price, string $op): float
    {
        if (str_ends_with($op, '%')) {
            $val = (float) rtrim($op, '%');
            return str_starts_with($op, '-')
                ? max(0, $price + ($price * $val / 100))   // val is negative
                : $price + ($price * $val / 100);
        }
        $val = (float) $op;
        if (str_starts_with($op, '+') || str_starts_with($op, '-')) {
            return max(0, $price + $val);
        }
        return max(0, $val); // fixed set
    }
}
