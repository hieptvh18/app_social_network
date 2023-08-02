<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stories extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'user_id','photo','is_active'];

    // format timestamp
    // public function getCreatedAtAttribute($timestamp)
    // {
    //     return caculateDatetime($timestamp);
    // }

    // public function getUpdatedAtAttribute($timestamp)
    // {
    //     return caculateDatetime($timestamp);
    // }

    // relatioship
    public function author(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
