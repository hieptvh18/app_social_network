<?php

namespace Modules\SocialNetwork\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\SocialNetwork\Http\Requests\NotificationUpdateRequest;
use Modules\SocialNetwork\Services\NotificationService;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(
        NotificationService $notificationService
    )
    {
        $this->notificationService = $notificationService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchNotifications(){
        return $this->notificationService->fetchNotifications();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveNotification(Request $request){
        return $this->notificationService->saveNotification($request);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateNotification($id,NotificationUpdateRequest $request){
        return $this->notificationService->updateIsRead($id,$request);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id){
        return $this->notificationService->delete($id);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function countUnread(){
        return $this->notificationService->countNotifiUnread();
    }
}
