<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminTermsCondition extends Model
{
    use HasFactory;

    protected $table = 'admin_terms_conditions';

    protected $fillable = [
        'title',
        'meta_title',
        'meta_description',
        'description',
    ];
}
