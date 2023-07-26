<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = ['user_id', 'message', 'is_read'];

    // format timestamp
    protected $casts = [
        'created_at' => 'datetime:Y M d H:i',
        'updated_at' => 'datetime:Y M d H:i',
    ];
}
