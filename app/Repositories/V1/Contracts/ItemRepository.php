<?php

namespace App\Repositories\V1\Contracts;

interface ItemRepository
{
    public function all(int $perPage);

    public function insert(array $values);

    public function upsert(array $values, array|string $uniqueBy, array|null $update);

    public function find(int $itemId);
}
