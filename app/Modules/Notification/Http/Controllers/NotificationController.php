<?php

namespace Modules\Notification\Http\Controllers;

use App\Http\Controllers\Api\AbstractApi;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Notification\Http\Requests\PushNotificationRequest;
use Modules\Notification\Http\Requests\SaveTokenRequest;
use Modules\Notification\Jobs\PushNotificationJob;
use Modules\Notification\Services\FcmService;

/**
 * @group Module Notification
 *
 * APIs for managing token
 *
 * @subgroup FCM token
 * @subgroupDescription AuthController
 */
class NotificationController extends AbstractApi
{

    protected $fcmService;

    /**
     * Class constructor.
     */
    public function __construct(FcmService $fcmService)
    {
        $this->fcmService = $fcmService;
    }

    /**
     * Save public device token
     *
     *
     * @param SaveTokenRequest $request
     * @return void
     */
    public function saveToken(SaveTokenRequest $request)
    {
        $item = $this->fcmService->saveToken($request);
        return $this->json(['data' => $item]);
    }

    /**
     * Push notification
     *
     *
     * @param Request $request
     * @return void
     */
    public function pushNotification(PushNotificationRequest $request)
    {
        $tokens = $request->input('tokens', []);
        // $data = $request->input('data');
        PushNotificationJob::dispatch('sendBatchNotification', [
            $tokens,
            $request->all()
        ]);
        // $msg = $this->fcmService->send($token, $data);
        return $this->json(['success' => true]);
    }
}
