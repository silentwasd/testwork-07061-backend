<?php

namespace App\Console\Commands;

use App\Models\BoardItem;
use Illuminate\Console\Command;

class PublicateAllCommand extends Command
{
    protected $signature = 'publicate:all';

    protected $description = 'Command description';

    public function handle()
    {
        $items = BoardItem::whereNull('published_at')->select('id')->get();
        BoardItem::whereNull('published_at')->update(['published_at' => now()]);
        BoardItem::whereIn('id', $items->map(fn ($x) => $x['id']))->searchable();
    }
}
