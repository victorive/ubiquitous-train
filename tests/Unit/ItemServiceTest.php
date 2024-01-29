<?php


use App\Repositories\V1\Contracts\ItemRepository;
use App\Services\V1\ItemService;
use Tests\TestCase;

class ItemServiceTest extends TestCase
{
    protected $mock;
    protected $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->mock = Mockery::mock(ItemRepository::class);
        $this->service = new ItemService($this->mock);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testGetItems(): void
    {
        $perPage = 12;

        $this->mock->shouldReceive('all')
            ->once()
            ->with($perPage)
            ->andReturn(['item1', 'item2']);

        $result = $this->service->getItems($perPage);

        $this->assertEquals(['item1', 'item2'], $result);
    }

    public function testGetItem(): void
    {
        $itemId = 1;
        $expectedItem = ['id' => 1, 'name' => 'item1'];

        $this->mock->shouldReceive('find')
            ->once()
            ->with($itemId)
            ->andReturn($expectedItem);

        $result = $this->service->getItem($itemId);

        $this->assertEquals($expectedItem, $result);
    }
}
