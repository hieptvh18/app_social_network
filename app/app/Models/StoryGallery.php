<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoryGallery extends Model
{
    use HasFactory;

    protected $fillable = ['soty_id', 'url'];

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
