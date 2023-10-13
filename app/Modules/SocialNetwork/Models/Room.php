<?php

namespace Modules\SocialNetwork\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['from','to'];

    // sender
    public function from(){
        return $this->belongsTo(User::class,'from','id');
    }

    // receiver
    public function to(){
        return $this->belongsTo(User::class,'to','id');
    }
}
