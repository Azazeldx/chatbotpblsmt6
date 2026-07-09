<?php

namespace App\Models;

use Awcodes\Curator\Models\Media;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Article extends Model
{
    use SoftDeletes;

    protected $table = 'articles';

    protected $fillable = [
        'views',
        'title',
        'slug',
        'preview_content',
        'content',
        'private',
        'fields',
        'metadata',
        'published_at',
    ];

    protected $casts = [
        'private' => 'boolean',
        'fields' => 'array',
        'metadata' => 'array',
        'published_at' => 'datetime'
    ];

    public function creator() : BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor() : BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function cover(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'cover_id', 'id');
    }

    public function tags() : BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'articles_tags');
    }

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function sponsors(): BelongsToMany
    {
        return $this->belongsToMany(Sponsor::class, 'article_sponsors')->withTrashed();
    }

    protected static function booted()
    {
        static::creating(function ($data) {
            $data->created_by = Auth::user()->id;
        });

        static::saving(function ($data) {
            $data->updated_by = Auth::user()->id;
            if ($data->isDirty('title') && empty($data->slug)) {
                $data->slug = Str::slug($data->title);
            }
        });
    }
}
