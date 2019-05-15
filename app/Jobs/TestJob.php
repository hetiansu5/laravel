<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

/**
 * Class TestJob
 * 入队列：TestJob::send($data);
 * 队列启动 php artisan queue:work redis --queue=test
 * 队列平滑结束 php artisan queue:restart
 *
 * @package App\Jobs
 */
class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const QUEUE_NAME = 'test';

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }


    /**
     * Send a job
     *
     * @param $data
     */
    public static function send($data)
    {
        static::dispatch($data)->onQueue(self::QUEUE_NAME);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info($this->data);
    }
}
