<?php

namespace Modules\SocialNetwork\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected $table = 'follows';


    protected $fillable = ['user_id','following_id'];
}
