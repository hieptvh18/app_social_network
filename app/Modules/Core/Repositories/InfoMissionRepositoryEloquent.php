<?php

namespace Modules\Core\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Core\Repositories\InfoMissionRepository;
use Modules\Core\Models\InfoMission;
use Modules\Core\Validators\InfoMissionValidator;

/**
 * Class InfoMissionRepositoryEloquent.
 *
 * @package namespace Modules\Core\Repositories;
 */
class InfoMissionRepositoryEloquent extends BaseRepository implements InfoMissionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return InfoMission::class;
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
    }

}
