<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','message','post_id'];
    
    public $timestamps = true;

    public function user(){
        return $this->belongsTo(User::class,'user_id','id')->select(['id','username','name','avatar']);
    }

    public function post(){
        return $this->belongsTo(Post::class,'post_id','id');
    }

    // format timestamp
    protected $casts = [
        'created_at' => 'datetime:Y M d H:i',
        'updated_at' => 'datetime:Y M d H:i',
    ];
}
