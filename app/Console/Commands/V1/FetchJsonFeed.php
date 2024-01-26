<?php

namespace App\Console\Commands\V1;

use App\Services\V1\ItemService;
use Exception;
use Illuminate\Console\Command;

class FetchJsonFeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:json-feed';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch JSON feed';

    public function __construct(private readonly ItemService $itemService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Fetching JSON feed...');

        try {
            $this->itemService->fetchItems();

            $this->info('JSON feed fetched successfully');
        } catch (Exception $exception) {
            $this->error('An error occurred: ' . $exception->getMessage());
        }
    }
}
