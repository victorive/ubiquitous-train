<?php

namespace App\Jobs\V1;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\Pool;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CacheImagesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public readonly array $thumbnails, public readonly int $itemId)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $requests = [];
        $thumbnailTypes = [];
        $batchedImages = [];

        $responses = Http::pool(function (Pool $pool) use (&$requests, &$thumbnailTypes, &$batchedImages) {
            foreach ($this->thumbnails as $thumbnail) {
                foreach ($thumbnail['urls'] as $url) {
                    $cacheKey = "image_{$this->itemId}_{$thumbnail['type']}";

                    if (!Cache::has($cacheKey)) {
                        $requests[] = $pool->async()->get($url);
                        $thumbnailTypes[] = $thumbnail['type'];
                    } else {
                        $batchedImages[$cacheKey] = Cache::get($cacheKey);
                    }
                }
            }
        });

        foreach ($responses as $index => $response) {
            $cacheKey = "image_" . $this->itemId . "_" . $thumbnailTypes[$index];
            $image = base64_encode($response->body());
            $batchedImages[$cacheKey] = $image;
        }

        Cache::putMany($batchedImages, 60 * 24);
    }
}
