<?php

namespace App\Repositories\V1\Contracts;

interface ItemRepository
{
    public function all(int $perPage);

    public function insert(array $values);

    public function find(int $itemId);
}
