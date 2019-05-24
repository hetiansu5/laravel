<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * 基类Job
 *
 */
class BaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected static $queue_name = 'base';

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
        static::dispatch($data)->onQueue(static::$queue_name);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
    }
}
