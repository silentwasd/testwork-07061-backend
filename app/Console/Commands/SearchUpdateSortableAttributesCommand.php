<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use MeiliSearch\Client;

class SearchUpdateSortableAttributesCommand extends Command
{
    protected $signature = 'search:update-sortable-attributes';

    protected $description = 'Update sortable attributes of eloquent models.';

    public function handle()
    {
        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));
        $client->index('board_items')->updateSortableAttributes(['published_at']);
    }
}
