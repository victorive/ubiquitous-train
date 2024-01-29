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
        $batchedImages = [];

        $urls = [];

        foreach ($this->thumbnails as $thumbnail) {
            foreach ($thumbnail['urls'] as $url) {
                $urls[$thumbnail['type']] = $url;
            }
        }

        $responses = Http::pool(function (Pool $pool) use ($urls) {
            foreach ($urls as $url) {
                $pool->head($url);
                $pool->get($url);
            }
        });

        foreach ($responses as $response) {
            if ($response->successful()) {
                $url = $response->effectiveUri()->__toString();

                $type = array_search($url, $urls, true);

                $cacheKey = "image_{$this->itemId}_$type";

                $image = $this->fetchImage($response, $cacheKey);

                if ($image !== null) {
                    $batchedImages[$cacheKey] = $image;
                }
            }
        }

        Cache::putMany($batchedImages, 60 * 60 * 24 * 7);
    }

    public function fetchImage($response, string $cacheKey): ?array
    {
        if (!$response->successful()) {
            return null;
        }

        $etag = $response->header('ETag');
        $expiresAt = $response->header('Expires');
        $lastModifiedAt = $response->header('Last-Modified');

        $cachedData = Cache::get($cacheKey);

        if (!empty($cachedData) && $cachedData['etag'] === $etag && $cachedData['expires_at'] >= now()->timestamp
            && $cachedData['last_modified_at'] <= now()->timestamp) {
            return $cachedData;
        }

        if ($response->successful() && $response->transferStats->getRequest()->getMethod() === "GET") {
            $image = base64_encode($response->body());
            $data = [
                'image' => $image,
                'etag' => $etag,
                'expires_at' => strtotime($expiresAt),
                'last_modified_at' => strtotime($lastModifiedAt),
            ];

            Cache::put($cacheKey, $data, 60 * 60 * 24 * 7);

            return $data;
        }

        return null;
    }
}
