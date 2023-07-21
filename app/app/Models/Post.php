<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "captions",
        "images",
    ];

    public $timestamps = true;

    // relashionship
    public function images(){
        return $this->hasMany(PostImage::class,'post_id','id');
    }

    public function author():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id'); 
    }

    public function likes(){
        return $this->hasMany(LikePost::class,'post_id','id')->select('user_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class,'post_id','id')->select(['id','message','created_at']);
    }

    // format timestamp
    protected $casts = [
        'created_at' => 'datetime:Y M d H:i',
        'updated_at' => 'datetime:Y M d H:i',
    ];
}
