<?php

namespace Modules\SocialNetwork\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SocialNetwork\Repositories\PostRepository;
use Modules\SocialNetwork\Models\Post;
use Modules\SocialNetwork\Validators\PostValidator;

/**
 * Class PostRepositoryEloquent.
 *
 * @package namespace Modules\SocialNetwork\Services;
 */
class PostRepositoryEloquent extends BaseRepository implements PostRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Post::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
