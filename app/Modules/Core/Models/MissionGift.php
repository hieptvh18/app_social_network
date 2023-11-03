<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\CoreHasUserAudit;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MissionGift.
 *
 * @package namespace Modules\Core\Models;
 */
class MissionGift extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes, CoreHasUserAudit;


    protected $table = "core_mission_gift";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'thumbnail_url',
        'type',
        'exchange_point',
        'allow_exchange_many',
        'exchange_qty',
        'apply_start_date',
        'apply_end_date',
        'is_active'

    ];

    protected $casts = [
        'is_active' => 'boolean',
        'allow_exchange_many' => 'boolean'
    ];

    public function histories()
    {
        return $this->hasMany(HistoryGift::class, 'gift_id');
    }

    public function info_missions()
    {
        return $this->hasMany(InfoMission::class);
    }
}
