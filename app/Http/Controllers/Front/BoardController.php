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
            ],
            'content' => 'nullable|string'
        ]);

        $items = BoardItem::search($validated['content'] ?? '');

        if (isset($validated['type']))
            $items->where('item_type', $validated['type']);

        $items = $items->orderBy('published_at', 'desc')->paginate(20);

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
