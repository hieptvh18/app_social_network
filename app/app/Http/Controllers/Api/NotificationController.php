<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\NotificationRepositoryInterface;

class NotificationController extends Controller
{
    protected $notifiRepository;

    public function __construct(NotificationRepositoryInterface $notifiRepository)
    {
        $this->notifiRepository = $notifiRepository;
    }

    public function fetchNotifications($userId){
        return $this->fetchNotifications($userId);
    }

    public function saveNotification(Request $request){
        return $this->notifiRepository->saveNotification($request);
    }

    public function delete($id){
        return $this->notifiRepository->delete($id);
    }
}
