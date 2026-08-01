<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'content',
        'image',
        'is_published',
        'likes_count',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function booted()
    {
        static::saving(function ($post) {
            if (empty($post->slug) && !empty($post->title)) {
                $baseSlug = \Illuminate\Support\Str::slug($post->title);
                $slug = $baseSlug ?: 'post';
                $originalSlug = $slug;
                $count = 1;

                while (static::where('slug', $slug)->where('id', '!=', $post->id ?? 0)->exists()) {
                    $slug = $originalSlug . '-' . $count++;
                }

                $post->slug = $slug;
            }
        });
    }

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(CommunityComment::class, 'community_post_id')->orderBy('created_at', 'asc');
    }

    public function likes()
    {
        return $this->hasMany(CommunityLike::class, 'community_post_id');
    }

    public function isLikedBy($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }
}
