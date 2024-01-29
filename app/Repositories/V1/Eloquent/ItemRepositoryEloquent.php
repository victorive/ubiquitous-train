<?php

namespace App\Repositories\V1\Eloquent;

use App\Models\Item;
use App\Repositories\V1\Contracts\ItemRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ItemRepositoryEloquent implements ItemRepository
{
    public function all(int $perPage): LengthAwarePaginator
    {
        return Item::query()->paginate($perPage);
    }

    public function insert(array $values): bool
    {
        return Item::query()->insert($values);
    }

    public function upsert(array $values, array|string $uniqueBy, array|null $update): bool
    {
        return Item::query()->upsert($values, $uniqueBy, $update);
    }

    public function find(int $itemId): Model|Collection|Builder|array|null
    {
        return Item::query()->find($itemId);
    }
}
