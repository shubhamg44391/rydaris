<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoMetadata extends Model
{
    use HasFactory;

    protected $table = 'seo_metadatas';

    protected $fillable = [
        'url_path',
        'page_name',
        'meta_title',
        'meta_description',
        'portal_type',
    ];
}
