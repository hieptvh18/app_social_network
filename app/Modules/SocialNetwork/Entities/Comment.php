<?php

namespace Modules\SocialNetwork\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Comment.
 *
 * @package namespace Modules\SocialNetwork\Entities;
 */
class Comment extends Model implements Transformable
{
    use TransformableTrait,HasFactory;

    protected $fillable = ['user_id','message','post_id'];
    
    public $timestamps = true;

    public function user(){
        return $this->belongsTo(User::class,'user_id','id')->select(['id','username','name','avatar']);
    }

    public function post(){
        return $this->belongsTo(Post::class,'post_id','id');
    }

    // format timestamp
    public function getCreatedAtAttribute($timestamp)
    {
        return caculateDatetime($timestamp);
    }

    public function getUpdatedAtAttribute($timestamp)
    {
        return caculateDatetime($timestamp);
    }

}
