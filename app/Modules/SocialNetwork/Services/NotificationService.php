<?php

namespace Modules\SocialNetwork\Services;

use App\Http\Controllers\Api\AbstractApi;
use Modules\SocialNetwork\Models\Notifications;
use Modules\SocialNetwork\Repositories\NotificationRepository;

class NotificationService extends AbstractApi
{
    protected $baseRepository;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->baseRepository = $notificationRepository;
    }

    public function fetchNotifications()
    {
        try{
            $data  = Notifications::where('user_id',auth()->id())
                        ->with(['user'])
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

    public function updateIsRead($id,$request)
    {
        try{
            $notfi = $this->baseRepository->update($request->all(),$id);

            return $this->respSuccess(['notification'=>$notfi],'Save notifi success!');
        }catch(\Throwable $e){
            report($e->getMessage());
            return $this->respError(['data'=>[]],'Have an error when save notification! '.$e->getMessage());
        }
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

    public function countNotifiUnread()
    {
        try{
            $data = ['count'=>Notifications::where('is_read',0)->where('user_id',auth()->id())->count()];
            return $this->respSuccess($data,'Success count!');
        }catch(\Throwable $e){
            report($e->getMessage());
            return $this->respError(false,'Something wrong when get count notifi! '.$e->getMessage(),500);
        }
    }

    /**
     * Delete old notifi
     */
    public function cleanNotifi(){
        try{
            logger('==============start cron cleanning notification==================');

            $notifications = Notifications::all(['id','created_at']);
            if($notifications->count()){
                foreach($notifications as $noti){
                    $date1 = $noti->created_at->format('Y-m-d'); // created_at
                    $date2 = \Carbon\Carbon::now()->format('Y-m-d'); // current date
                    $datetime1 = date_create($date1);
                    $datetime2 = date_create($date2);
                    $interval = date_diff($datetime2, $datetime1);

                    if($interval->days >= 30){
                        logger('==============cron delete notification id = '.$noti->id.'==================');
                        // delete
                        $noti->delete();
                    }
                }
            }

            logger('==============finish success cron cleanning notification==================');
        }catch(\Throwable $e){
            logger('==============cron cleanning notification have error! '.$e->getMessage());
            report($e->getMessage());
        }
    }
}
