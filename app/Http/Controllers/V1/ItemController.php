<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Services\V1\ItemService;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ItemController extends Controller
{
    public function __construct(private readonly ItemService $itemService)
    {
    }

    public function getItems(): View
    {
        $perPage = 12;
        $items = $this->itemService->getItems($perPage);

        foreach ($items as $item) {
            $item->images = $this->getImagesForItem($item->id);
        }

        return view('index', ['items' => $items]);
    }

    private function getImagesForItem($itemId): array
    {
        $images = [];
        $types = ['pc', 'mobile', 'tablet'];

        foreach ($types as $type) {
            $imageKey = "image_{$itemId}_$type";
            $images[$type] = Cache::get($imageKey);
        }

        return $images;
    }

    public function getItem(int $itemId): View
    {
        $item = $this->itemService->getItem($itemId);
        $item->images = $this->getImagesForItem($itemId);

        return view('show', ['item' => $item]);
    }
}
