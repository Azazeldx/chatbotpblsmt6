<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'category_name',
        'slug',
        'default',
        'searchable',
        'card_layout',
        'detail_page',
        'fields'
    ];

    protected $casts = [
        'default' => 'boolean',
        'searchable' => 'boolean',
        'fields' => 'array',
    ];

    public function articles() : HasMany
    {
        return $this->hasMany(Article::class, 'category_id');
    }

    protected static function booted()
    {
        static::saving(function ($data) {
            if ($data->isDirty('category_name') && empty($data->slug)) {
                $data->slug = Str::slug($data->category_name);
            }

            $record = Category::where([['id', '!=', $data->id], ['default', 1]])->first();
            if (!empty($record) && $data->default == 1) {
                $record->update(['default' => 0]);
            } else if (empty($record) && $data->default == 1) {
                $data->default = 1;
                $data->searchable = 1;
            }
        });
    }
}
