<?php

namespace Modules\SocialNetwork\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = ['user_id', 'message', 'is_read'];

    // format timestamp

    public function getCreatedAtAttribute($timestamp)
    {
        return caculateDatetime($timestamp);
    }

    public function getUpdatedAtAttribute($timestamp)
    {
        return caculateDatetime($timestamp);
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    protected $casts = ['is_read'=>'boolean'];
}
