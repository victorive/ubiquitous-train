<?php

namespace App\Services\V1;

use App\Jobs\V1\CacheImagesJob;
use App\Repositories\V1\Contracts\ItemRepository;
use JsonException;
use JsonMachine\Exception\InvalidArgumentException;
use JsonMachine\Items;
use JsonMachine\JsonDecoder\ExtJsonDecoder;

class ItemService
{
    private string $url;

    public function __construct(private readonly ItemRepository $itemRepository)
    {
        $this->url = config('services.json-feed.url');
    }

    public function getItems(int $perPage)
    {
        return $this->itemRepository->all($perPage);
    }

    public function getItem(int $itemId)
    {
        return $this->itemRepository->find($itemId);
    }

    /**
     * @throws InvalidArgumentException|JsonException
     */
    public function fetchItems(): void
    {
        $jsonStream = fopen($this->url, 'rb');

        $items = Items::fromStream($jsonStream, [
            'pointer' => '/items',
            'decoder' => new ExtJsonDecoder(true)
        ]);

        $batchedItems = [];

        foreach ($items as $itemData) {
            $itemData['aliases'] = json_encode($itemData['aliases'], JSON_THROW_ON_ERROR);
            $itemData['attributes'] = json_encode($itemData['attributes'], JSON_THROW_ON_ERROR);

            CacheImagesJob::dispatch($itemData['thumbnails'], $itemData['id']);

            $itemData['thumbnails'] = json_encode($itemData['thumbnails'], JSON_THROW_ON_ERROR);
            $itemData['created_at'] = now()->toDateTimeString();
            $itemData['updated_at'] = now()->toDateTimeString();

            $batchedItems[] = $itemData;

            if (count($batchedItems) >= 300) {
                $this->itemRepository->upsert($batchedItems, 'id', ['id', 'name', 'license', 'wlStatus',
                    'aliases', 'link', 'thumbnails', 'attributes', 'updated_at']);
                $batchedItems = [];
            }
        }

        $this->itemRepository->upsert($batchedItems, 'id', ['id', 'name', 'license', 'wlStatus',
            'aliases', 'link', 'thumbnails', 'attributes', 'updated_at']);
    }
}
