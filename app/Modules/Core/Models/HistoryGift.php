<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\CoreHasUserAudit;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class HistoryGift.
 *
 * @package namespace Modules\Core\Models;
 */
class HistoryGift extends Model implements Transformable
{
    use TransformableTrait, CoreHasUserAudit, SoftDeletes;

    protected $table = "core_history_gift";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gift_id',
        'gift_result',
        'created_at',
        'created_by',
        'updated_by',
        'mission_type',
        'status',
        'reason_refuse_approve'
    ];

    protected $casts = ['gift_result' => 'json'];

    public function missionGift()
    {
        return $this->belongsTo(MissionGift::class, 'gift_id');
    }

    public function received(){
        $this->update([
            'status' => 'RECEIVED'
        ]);
    }

    public function cancelled(){
        $this->update([
            'status' => 'CANCELLED'
        ]);
    }

}
