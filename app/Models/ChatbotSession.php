<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ChatbotSession extends Model
{
    protected $fillable = [
        'title',
        'user_id'
    ];

    public function messages()
    {
        return $this->hasMany(ChatbotMessage::class, 'session_id');
    }

    protected static function booted()
    {
        static::creating(function ($data) {
            if (Auth::check()) {
                $data->user_id = Auth::id();
            }
        });
    }
}
