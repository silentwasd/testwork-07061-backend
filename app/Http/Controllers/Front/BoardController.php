<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BoardItem;

class BoardController extends Controller
{
    public function items()
    {
        $items = BoardItem::whereNotNull('published_at')
            ->whereNull('removed_at')
            ->orderByDesc('published_at')
            ->get()
            ->map(function (BoardItem $item) {
                $data = $item->toArray();
                $data['price'] = [
                    'value' => $data['price_value'],
                    'range' => $data['price_range'],
                    'type' => $data['price_type']
                ];
                unset($data['price_value'], $data['price_range'], $data['price_type']);
                return $data;
            });

        return response()->json([
            'success' => true,
            'data' => $items
        ]);
    }
}
