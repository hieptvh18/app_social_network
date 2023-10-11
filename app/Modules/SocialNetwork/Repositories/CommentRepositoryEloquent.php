<?php

namespace Modules\SocialNetwork\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SocialNetwork\Repositories\CommentRepository;
use Modules\SocialNetwork\Entities\Comment;
use Modules\SocialNetwork\Validators\CommentValidator;

/**
 * Class CommentRepositoryEloquent.
 *
 * @package namespace Modules\SocialNetwork\Repositories;
 */
class CommentRepositoryEloquent extends BaseRepository implements CommentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Comment::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
