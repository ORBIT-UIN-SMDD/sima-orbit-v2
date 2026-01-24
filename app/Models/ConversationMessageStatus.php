<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConversationMessageStatus extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function conversationMessage()
    {
        return $this->belongsTo(ConversationMessage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
