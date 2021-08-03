<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Message extends Model
{
    protected $fillable = ['channel', 'sender', 'content'];
    public function sender()
    {
        return $this->belongsTo(User::class,  'sender');
    }

    public function channel()
    {
        return $this->belongsTo(User::class, 'channel');
    }
}
