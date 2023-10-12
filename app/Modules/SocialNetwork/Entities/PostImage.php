<?php

namespace Modules\SocialNetwork\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    use HasFactory;


    public function getCreatedAtAttribute($timestamp)
    {
        return caculateDatetime($timestamp);
    }

    public function getUpdatedAtAttribute($timestamp)
    {
        return caculateDatetime($timestamp);
    }
}
