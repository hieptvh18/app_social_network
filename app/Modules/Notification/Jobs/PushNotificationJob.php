<?php

namespace Modules\Notification\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Notification\Services\FcmService;

class PushNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $serviceMethod;

    protected $methodParams;

    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    // public $queue = 'notification';

    /**
     * Notification constructor.
     * @param $serviceMethod
     * @param $methodParams
     * @param string $methodHttp
     */
    public function __construct($serviceMethod, $methodParams = [[]])
    {
        $this->onQueue('notification');
        $this->serviceMethod = $serviceMethod;
        $this->methodParams = $methodParams;
    }

    /**
     * @param FcmService $notificationService
     */
    public function handle(FcmService $notificationService)
    {
        call_user_func_array(
            [
                $notificationService,
                $this->serviceMethod,
            ],
            $this->methodParams
        );
    }
}
