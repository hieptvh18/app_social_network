<?php

namespace Modules\Notification\Services;

use App\Exceptions\ApiException;
use App\Services\BaseService;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Core\Services\NotificationService;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Factory;
use Modules\Notification\Models\DeviceToken;
use Jenssegers\Agent\Agent;

class FcmService
{

    protected $messaging;
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->messaging = (new Factory)->withServiceAccount(json_encode(config('notification.firebase.credential')))
            ->withProjectId(config('notification.firebase.project_id'))->createMessaging();
    }

    public function saveToken(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all(['token', 'user_id', 'bizapp_alias']);
            $user_agent = new Agent();
            $data['ip_address'] = $request->ip();
            $data['user_agent'] = $user_agent->getUserAgent();
            $item = DeviceToken::create($data);
            DB::commit();
            return $item;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function sendBatchNotification($deviceTokens = [], $request)
    {
        try {
            // query user token from request
            if (!empty($request['user_ids'])) {
                $deviceTokens = DeviceToken::whereIn('user_id', $request['user_ids'])->pluck('token')->all();
            }

            if (count($deviceTokens) > 1000) {
                throw new ApiException('Không được phép gửi quá 1000 device', 500); // send batch allow max 1000 device
            }
            
            $topic = $request['topic'] ?? 'default';
            $body = $request['body'];
            $title = $request['title'] ?? 'Thông báo mới';
            $data = $request['custom_data'] ?? null;

            $this->messaging->subscribeToTopic($topic, $deviceTokens);
            $message = CloudMessage::fromArray([
                'topic' => $topic,
                'notification' => [
                    'body' => $body,
                    'title' => $title,
                    'icon' => 'https://dev.eduquiz.vn/logo/logo-256.png'
                ], 
                'data' => $data, 
            ]);
            $result = $this->messaging->send($message);
            
            $this->messaging->unsubscribeFromTopic($topic, $deviceTokens);

            return $result;
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), 500);
        }
    }
}
