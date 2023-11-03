<?php

namespace Modules\Core\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class RewardPoint.
 *
 * @package namespace Modules\Core\Models;
 */
class RewardPoint extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'user_reward_points';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'reward_point'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
