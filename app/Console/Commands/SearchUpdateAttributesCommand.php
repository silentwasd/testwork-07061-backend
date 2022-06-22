<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use MeiliSearch\Client;

class SearchUpdateAttributesCommand extends Command
{
    protected $signature = 'search:update-attributes';

    protected $description = 'Update sortable and filterable attributes of eloquent models.';

    public function handle()
    {
        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));
        $client->index('board_items')->updateSortableAttributes(['published_at']);
        $client->index('board_items')->updateFilterableAttributes(['item_type']);
    }
}
