<?php

namespace App\Jobs\Middleware;

use Illuminate\Support\Facades\Redis;

class RateLimited
{
    /**
     * Обработать задание в очереди.
     *
     * @param  mixed  $job
     * @param  callable  $next
     * @return mixed
     */
    public function handle($job, $next)
    {
        Redis::throttle('key')
            ->block(0)->allow(1)->every(60)
            ->then(function () use ($job, $next) {
                // Блокировка получена ...

                $next($job);
            }, function () use ($job) {
                // Не удалось получить блокировку ...

                $job->release(60);
            });
    }
}
