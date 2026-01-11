<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = ['history_id','role','message'];

    public function history(){
        return $this->belongsTo(ChatHistory::class);
    }
}