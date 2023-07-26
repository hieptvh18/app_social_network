<?php
namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

Interface NotificationRepositoryInterface
{

    /**
     * Fetch notification
     * @param $userId 
     */
    public function fetchNotifications($userId);

    /**
     * @param $requestData
     * post comments
     */
    public function saveNotification($requestData);

    /**
     * Delete notification
     * @param $id
     */
    public function delete($id);
}

?>
