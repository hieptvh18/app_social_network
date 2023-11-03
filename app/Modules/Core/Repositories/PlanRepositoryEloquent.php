<?php

namespace Modules\Core\Repositories;

use Modules\Core\Models\Plan;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Core\Repositories\Criteria\MyCriteria;



/**
 * Class RoleRepositoryEloquent.
 *
 * @package namespace Modules\Auth\Repositories;
 */
class PlanRepositoryEloquent extends BaseRepository implements PlanRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Plan::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
