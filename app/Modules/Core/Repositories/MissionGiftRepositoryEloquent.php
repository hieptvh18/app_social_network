<?php

namespace Modules\Core\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Core\Repositories\MissionGiftRepository;
use Modules\Core\Models\MissionGift;
use Modules\Core\Repositories\Criteria\FilterIsActive;
use Modules\Core\Validators\MissionGiftValidator;

/**
 * Class MissionGiftRepositoryEloquent.
 *
 * @package namespace Modules\Core\Repositories;
 */
class MissionGiftRepositoryEloquent extends BaseRepository implements MissionGiftRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MissionGift::class;
    }

    public function getFieldsSearchable()
    {
        // $locale = config('app.locale');
        return
            [
                "name" => 'like',
                'description'  => 'like',
                // 'is_active'
            ];
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(FilterIsActive::class));
    }

}
