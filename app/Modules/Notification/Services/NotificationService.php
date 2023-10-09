<?php

namespace Modules\Notification\Services;



interface NotificationService
{
    public function sendBatchNotification($deviceTokens, $data);

    public function sendNotification($data);

    public function subscribeTopic($deviceTokens, $topicName);

    public function unsubscribeTopic($deviceTokens, $topicName);
}
