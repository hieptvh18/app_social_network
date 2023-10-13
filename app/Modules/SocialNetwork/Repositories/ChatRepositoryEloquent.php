<?php

namespace Modules\SocialNetwork\Repositories;

use Modules\SocialNetwork\Models\Message;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SocialNetwork\Repositories\ChatRepository;
use Modules\SocialNetwork\Validators\ChatValidator;

/**
 * Class ChatRepositoryEloquent.
 *
 * @package namespace Modules\SocialNetwork\Services;
 */
class ChatRepositoryEloquent extends BaseRepository implements ChatRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Message::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
