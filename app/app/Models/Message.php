<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['message','from','to','room_id'];

    // sender
    public function from(){
        return $this->belongsTo(User::class,'from','id');
    }

    // receiver
    public function to(){
        return $this->belongsTo(User::class,'to','id');
    }
}
