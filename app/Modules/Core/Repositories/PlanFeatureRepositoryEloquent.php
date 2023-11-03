<?php

namespace Modules\Core\Repositories;

use Modules\Core\Models\PlanFeature;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Core\Repositories\Criteria\MyCriteria;



/**
 * Class PlanFeatureRepositoryEloquent.
 *
 * @package namespace Modules\Auth\Repositories;
 */
class PlanFeatureRepositoryEloquent extends BaseRepository implements PlanFeatureRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PlanFeature::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
