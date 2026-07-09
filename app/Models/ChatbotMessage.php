<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotMessage extends Model
{
    protected $fillable = [
        'session_id',
        'sender',
        'message'
    ];

    /**
     * Perbarui updated_at session induk setiap ada pesan baru,
     * agar "inaktivitas" dihitung dari pesan terakhir (dipakai auto-cleanup guest).
     */
    protected $touches = ['session'];

    public function session()
    {
        return $this->belongsTo(ChatbotSession::class);
    }
}
