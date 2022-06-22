<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BoardItem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BoardController extends Controller
{
    public function items(Request $request)
    {
        $validated = $request->validate([
            'page' => 'nullable|integer|min:1',
            'type' => [
                'nullable',
                Rule::in(config('board.item_types'))
            ]
        ]);

        $items = BoardItem::whereNotNull('published_at')
            ->whereNull('removed_at')
            ->orderByDesc('published_at');

        if (isset($validated['type']))
            $items->where('item_type', $validated['type']);

        $items = $items->paginate(20);

        $items->setCollection(
            collect($items->items())
                ->map(function (BoardItem $item) {
                    $data = $item->toArray();
                    $data['price'] = [
                        'value' => $data['price_value'],
                        'range' => $data['price_range'],
                        'type' => $data['price_type']
                    ];
                    unset($data['price_value'], $data['price_range'], $data['price_type']);
                    return $data;
                })
        );

        return response()->json([
            'success' => true,
            'data' => $items
        ]);
    }
}
