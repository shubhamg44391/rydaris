<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemoInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'first_name',
        'middle_name',
        'last_name',
        'company_name',
        'employee_size',
        'email',
        'country_code',
        'contact_details',
        'budget',
        'description',
        'status',
    ];
}
