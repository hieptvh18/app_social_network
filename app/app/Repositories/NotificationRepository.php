<?php

namespace App\Repositories;

use App\Models\Notifications;
use App\Repositories\Interfaces\NotificationRepositoryInterface;

class NotificationRepository extends AbstractApi implements NotificationRepositoryInterface
{
    public function fetchNotifications($userId)
    {
        try{
            $data  = Notifications::where('user_id',$userId)
                        ->orderByDesc('created_at')
                        ->get();

            return $this->respSuccess(['notifications'=>$data,'Fetch noti success!']);
        }catch(\Throwable $e){
            report($e->getMessage());
            return $this->respError(['data'=>[]],'Have an error when fetch notifications! '.$e->getMessage());
        }
    }

    public function saveNotification($request)
    {
        try{
            $noti = new Notifications();
            $noti->$request->fill($request->all());
            $noti->save();

            return $this->respSuccess(['notification'=>$noti],'Save notifi success!');
        }catch(\Throwable $e){
            report($e->getMessage());
            return $this->respError(['data'=>[]],'Have an error when save notification! '.$e->getMessage());
        }
    }

    // update status noti is_read = true;
    public function updateStatus($id){
        
    }

    public function delete($id){
        try{
            Notifications::destroy($id);
            return $this->respSuccess(null,'Delete success notification');
        }catch(\Throwable $e){
            report($e->getMessage());
            return $this->respError(false,'Delete noti fail! '.$e->getMessage());
        }
    }
}
