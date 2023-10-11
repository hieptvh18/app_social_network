<?php

namespace Modules\SocialNetwork\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
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
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchNotifications($userId){
        return $this->notificationService->fetchNotifications($userId);
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
