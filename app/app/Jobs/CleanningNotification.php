<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Repositories\NotificationRepository;

class CleanningNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $notificationRepository;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->notificationRepository = new NotificationRepository();
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $this->notificationRepository->cleanNotifi();
    }
}
