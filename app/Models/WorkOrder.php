<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_order_number',
        'vendor_id',
        'branch_id',
        'vehicle_id',
        'mechanic_workshop',
        'vehicle_status',
        'progress_percentage',
        'checklist_completed',
        'incident_flag',
        'status',
        'completed_at',
    ];

    protected $casts = [
        'checklist_completed' => 'array',
        'completed_at' => 'datetime',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }
}
