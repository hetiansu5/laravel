<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Log;

/**
 * Class TestJob
 * 入队列：TestJob::send($data);
 * 队列启动 php artisan queue:work redis --queue=test
 * 队列平滑结束 php artisan queue:restart
 *
 * @package App\Jobs
 */
class TestJob extends BaseJob
{

    protected static $queue_name = 'test';

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info($this->data . 'start');
        sleep(5);
        Log::info($this->data . 'end');
    }

}
