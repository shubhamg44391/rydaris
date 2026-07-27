<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Branch;
use App\Models\MaintenanceSchedule;
use App\Models\MaintenanceRequest;
use App\Models\WorkOrder;

class VendorMaintenanceScheduleController extends Controller
{
    // 1. Maintenance Schedules
    public function schedulesIndex()
    {
        $user = auth()->user();
        $vendorId = $user->id;
        $currentBranchId = $user->current_branch_id;

        $vehicles = Vehicle::where('vendor_id', $vendorId)
            ->when($currentBranchId, function($q) use ($currentBranchId) {
                return $q->where('branch_id', $currentBranchId);
            })->get();

        $schedules = MaintenanceSchedule::with(['vehicle', 'branch'])
            ->where('vendor_id', $vendorId)
            ->when($currentBranchId, function($q) use ($currentBranchId) {
                return $q->where('branch_id', $currentBranchId);
            })->latest()->get();

        return view('vendor.maintenance-schedules.schedules-index', compact('vehicles', 'schedules'));
    }

    public function schedulesCreate()
    {
        return redirect()->route('vendor.maintenance-schedules.index', ['openModal' => 1]);
    }

    public function schedulesStore(Request $request)
    {
        $user = auth()->user();
        $vendorId = $user->id;
        $currentBranchId = $user->current_branch_id;

        $vehicleId = $request->vehicle_id;
        if (!$vehicleId) {
            $firstVehicle = Vehicle::where('vendor_id', $vendorId)->first();
            $vehicleId = $firstVehicle ? $firstVehicle->id : 1;
        }

        $scheduleId = $request->schedule_id ?? $request->edit_id;
        $schedule = $scheduleId ? MaintenanceSchedule::where('vendor_id', $vendorId)->find($scheduleId) : null;

        if ($schedule) {
            $schedule->update([
                'vehicle_id' => $vehicleId,
                'target_km' => $request->target_km ?? $schedule->target_km,
                'engine_hours' => $request->engine_hours ?? $schedule->engine_hours,
                'next_due_date' => $request->next_due_date ?? $schedule->next_due_date,
                'checklist_summary' => $request->checklist_summary ?? $schedule->checklist_summary,
            ]);
            $message = 'Maintenance Schedule updated successfully in database.';
        } else {
            $schedule = MaintenanceSchedule::create([
                'vendor_id' => $vendorId,
                'branch_id' => $currentBranchId,
                'vehicle_id' => $vehicleId,
                'target_km' => $request->target_km ?? 10000,
                'engine_hours' => $request->engine_hours ?? 500,
                'next_due_date' => $request->next_due_date ?? now()->addMonths(6)->format('Y-m-d'),
                'checklist_summary' => $request->checklist_summary ?? 'Regular Maintenance Check',
                'status' => 'on_schedule',
            ]);
            $message = 'Maintenance Schedule stored successfully in database.';
        }

        $schedule->load('vehicle');

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $schedule,
                'is_update' => (bool)$scheduleId
            ]);
        }

        return redirect()->route('vendor.maintenance-schedules.index')->with('success', $message);
    }

    // 2. Generate Requests
    public function requestsIndex()
    {
        $user = auth()->user();
        $vendorId = $user->id;
        $currentBranchId = $user->current_branch_id;

        $vehicles = Vehicle::where('vendor_id', $vendorId)
            ->when($currentBranchId, function($q) use ($currentBranchId) {
                return $q->where('branch_id', $currentBranchId);
            })->get();

        $requests = MaintenanceRequest::with(['vehicle', 'branch'])
            ->where('vendor_id', $vendorId)
            ->when($currentBranchId, function($q) use ($currentBranchId) {
                return $q->where('branch_id', $currentBranchId);
            })->latest()->get();

        return view('vendor.maintenance-requests.index', compact('vehicles', 'requests'));
    }

    public function requestsCreate()
    {
        return redirect()->route('vendor.maintenance-requests.index', ['openModal' => 1]);
    }

    public function requestsStore(Request $request)
    {
        $user = auth()->user();
        $vendorId = $user->id;
        $currentBranchId = $user->current_branch_id;

        $vehicleId = $request->vehicle_id;
        if (!$vehicleId) {
            $firstVehicle = Vehicle::where('vendor_id', $vendorId)->first();
            $vehicleId = $firstVehicle ? $firstVehicle->id : 1;
        }

        $requestId = $request->request_id ?? $request->edit_id;
        $mRequest = $requestId ? MaintenanceRequest::where('vendor_id', $vendorId)->find($requestId) : null;

        if ($mRequest) {
            $mRequest->update([
                'vehicle_id' => $vehicleId,
                'interval_type' => $request->interval_type ?? $mRequest->interval_type,
                'priority' => $request->priority ?? $mRequest->priority,
                'checklist_tasks' => $request->checklist_tasks ?? $mRequest->checklist_tasks,
                'notes' => $request->notes ?? $mRequest->notes,
            ]);
            $message = 'Maintenance Request updated successfully.';
        } else {
            $mRequest = MaintenanceRequest::create([
                'request_number' => 'REQ-2026-' . rand(100, 999),
                'vendor_id' => $vendorId,
                'branch_id' => $currentBranchId,
                'vehicle_id' => $vehicleId,
                'interval_type' => $request->interval_type ?? 'Engine Hours',
                'priority' => $request->priority ?? 'Medium',
                'checklist_tasks' => $request->checklist_tasks ?? ['Engine Oil & Filter Replace', 'Brake Pad Check'],
                'notes' => $request->notes,
                'status' => 'pending',
            ]);
            $message = 'Maintenance Request ticket stored successfully in database.';
        }

        $mRequest->load('vehicle');

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $mRequest,
                'is_update' => (bool)$requestId
            ]);
        }

        return redirect()->route('vendor.maintenance-requests.index')->with('success', $message);
    }

    // 3. Vendor Work Orders
    public function workOrdersIndex()
    {
        $user = auth()->user();
        $vendorId = $user->id;
        $currentBranchId = $user->current_branch_id;

        $vehicles = Vehicle::where('vendor_id', $vendorId)
            ->when($currentBranchId, function($q) use ($currentBranchId) {
                return $q->where('branch_id', $currentBranchId);
            })->get();

        $workOrders = WorkOrder::with(['vehicle', 'branch'])
            ->where('vendor_id', $vendorId)
            ->when($currentBranchId, function($q) use ($currentBranchId) {
                return $q->where('branch_id', $currentBranchId);
            })->latest()->get();

        return view('vendor.work-orders.index', compact('vehicles', 'workOrders'));
    }

    public function workOrdersCreate()
    {
        return redirect()->route('vendor.work-orders.index', ['openModal' => 1]);
    }

    public function workOrdersStore(Request $request)
    {
        $user = auth()->user();
        $vendorId = $user->id;
        $currentBranchId = $user->current_branch_id;

        $vehicleId = $request->vehicle_id;
        if (!$vehicleId) {
            $firstVehicle = Vehicle::where('vendor_id', $vendorId)->first();
            $vehicleId = $firstVehicle ? $firstVehicle->id : 1;
        }

        $woId = $request->work_order_id ?? $request->edit_id;
        $workOrder = $woId ? WorkOrder::where('vendor_id', $vendorId)->find($woId) : null;

        $progress = $request->progress_percentage ?? 0;
        $status = ($progress >= 100) ? 'completed' : 'in_progress';
        $completedAt = ($progress >= 100) ? now() : null;

        $submittedTasks = $request->input('checklist_completed', []);
        $existingMap = [];

        if ($workOrder && is_array($workOrder->checklist_completed)) {
            foreach ($workOrder->checklist_completed as $item) {
                if (is_array($item) && isset($item['task'])) {
                    $existingMap[$item['task']] = $item['time'] ?? now()->format('Y-m-d H:i');
                } elseif (is_string($item)) {
                    $existingMap[$item] = $workOrder->updated_at ? $workOrder->updated_at->format('Y-m-d H:i') : now()->format('Y-m-d H:i');
                }
            }
        }

        $nowStr = now()->format('Y-m-d H:i');
        $checklistWithTimestamps = [];
        foreach ($submittedTasks as $taskName) {
            if (!empty($taskName)) {
                $checklistWithTimestamps[] = [
                    'task' => $taskName,
                    'time' => $existingMap[$taskName] ?? $nowStr,
                ];
            }
        }

        if ($workOrder) {
            $workOrder->update([
                'vehicle_id' => $vehicleId,
                'mechanic_workshop' => $request->mechanic_workshop ?? $workOrder->mechanic_workshop,
                'vehicle_status' => $request->vehicle_status ?? $workOrder->vehicle_status,
                'progress_percentage' => $progress,
                'checklist_completed' => $checklistWithTimestamps,
                'incident_flag' => $request->incident_flag ?? $workOrder->incident_flag,
                'status' => $status,
                'completed_at' => $completedAt ?? $workOrder->completed_at,
            ]);
            $message = 'Work Order updated successfully in database.';
        } else {
            $workOrder = WorkOrder::create([
                'work_order_number' => 'WO-2026-' . rand(100, 999),
                'vendor_id' => $vendorId,
                'branch_id' => $currentBranchId,
                'vehicle_id' => $vehicleId,
                'mechanic_workshop' => $request->mechanic_workshop ?? 'Ramesh Repair Services',
                'vehicle_status' => $request->vehicle_status ?? 'In Maintenance',
                'progress_percentage' => $progress,
                'checklist_completed' => $checklistWithTimestamps,
                'incident_flag' => $request->incident_flag ?? 'No Incident',
                'status' => $status,
                'completed_at' => $completedAt,
            ]);
            $message = 'Work Order stored successfully in database.';
        }

        $workOrder->load('vehicle');

        if ($vehicleId) {
            $targetReqStatus = ($progress >= 100) ? 'completed' : 'converted';
            MaintenanceRequest::where('vendor_id', $vendorId)
                ->where('vehicle_id', $vehicleId)
                ->where('status', '!=', 'completed')
                ->update(['status' => $targetReqStatus]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $workOrder,
                'is_update' => (bool)$woId
            ]);
        }

        return redirect()->route('vendor.work-orders.index')->with('success', $message);
    }
}
