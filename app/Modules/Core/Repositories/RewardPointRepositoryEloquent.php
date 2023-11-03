<?php

namespace Modules\Core\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Core\Repositories\RewardPointRepository;
use Modules\Core\Models\RewardPoint;
use Modules\Core\Validators\RewardPointValidator;

/**
 * Class RewardPointRepositoryEloquent.
 *
 * @package namespace Modules\Core\Repositories;
 */
class RewardPointRepositoryEloquent extends BaseRepository implements RewardPointRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RewardPoint::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
