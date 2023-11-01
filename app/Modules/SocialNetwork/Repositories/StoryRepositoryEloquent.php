<?php

namespace Modules\SocialNetwork\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SocialNetwork\Repositories\StoryRepository;
use Modules\SocialNetwork\Models\Stories;
use Modules\SocialNetwork\Repositories\Criteria\FilterIsFeatured;
use Modules\SocialNetwork\Validators\StoryValidator;

/**
 * Class StoryRepositoryEloquent.
 *
 * @package namespace Modules\SocialNetwork\Services;
 */
class StoryRepositoryEloquent extends BaseRepository implements StoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Stories::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(FilterIsFeatured::class));
    }

}
