<?php

namespace Modules\Core\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Core\Repositories\UserMissionRepository;
use Modules\Core\Models\UserMission;
use Modules\Core\Repositories\Criteria\FilterStatus;
use Modules\Core\Validators\UserMissionValidator;

/**
 * Class UserMissionRepositoryEloquent.
 *
 * @package namespace Modules\Core\Repositories;
 */
class UserMissionRepositoryEloquent extends BaseRepository implements UserMissionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserMission::class;
    }

    public function getFieldsSearchable()
    {
        return
            [
                'name' => 'like',
                'code'  => 'like',
            ];
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(FilterStatus::class));
    }

}
