<?php

namespace Database\Seeders;

use App\Models\BoardItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BoardItemSeeder extends Seeder
{
    public function run()
    {
        BoardItem::factory()->count(10000)->create();
    }
}
