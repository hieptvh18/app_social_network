<?php

namespace Modules\Notification\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Notification\Repositories\NotificationRepository;
use Modules\Notification\Entities\Notification;
use Modules\Notification\Validators\NotificationValidator;

/**
 * Class NotificationRepositoryEloquent.
 *
 * @package namespace Modules\Notification\Repositories;
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
