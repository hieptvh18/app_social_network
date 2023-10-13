<?php

namespace Modules\SocialNetwork\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelLike\Traits\Likeable;

class Stories extends Model
{
    use HasFactory,Likeable;

    protected $fillable = ['content', 'user_id','photo','css','is_active'];

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
