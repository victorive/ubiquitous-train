<?php


use App\Jobs\V1\CacheImagesJob;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CacheImageJobTest extends TestCase
{
    public function testFetchImage(): void
    {
        Http::fake([
            '*' => Http::response('OK', 200, ['ETag' => '12345', 'Expires' => 'Mon, 3 Jan 2022 00:00:00 GMT', 'Last-Modified' => 'Sun, 2 Jan 2022 00:00:00 GMT']),
        ]);

        $response = Http::get('http://example.com/image.png');

        $job = new CacheImagesJob([], 1);

        $result = $job->fetchImage($response, 'image_1_pc');

        $this->assertIsArray($result);
        $this->assertArrayHasKey('image', $result);
        $this->assertArrayHasKey('etag', $result);
        $this->assertArrayHasKey('expires_at', $result);
        $this->assertArrayHasKey('last_modified_at', $result);
    }
}
