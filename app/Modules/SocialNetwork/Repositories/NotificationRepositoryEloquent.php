<?php

namespace Modules\SocialNetwork\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\SocialNetwork\Repositories\NotificationRepository;
use Modules\SocialNetwork\Entities\Notification;
use Modules\SocialNetwork\Validators\NotificationValidator;

/**
 * Class NotificationRepositoryEloquent.
 *
 * @package namespace Modules\SocialNetwork\Repositories;
 */
class NotificationRepositoryEloquent extends BaseRepository implements NotificationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Notification::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
