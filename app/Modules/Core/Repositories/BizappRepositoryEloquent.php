<?php

namespace Modules\Core\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Core\Repositories\BizappRepository;
use Modules\Core\Models\Bizapp;
use Modules\Core\Repositories\Criteria\FilterIsActive;
use Modules\Core\Validators\BizappValidator;

/**
 * Class BizappRepositoryEloquent.
 *
 * @package namespace Modules\Core\Repositories;
 */
class BizappRepositoryEloquent extends BaseRepository implements BizappRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Bizapp::class;
    }


    /**
     * Get Searchable Fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return
            [
                'name' => 'like',
                'alias' => 'like'
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
