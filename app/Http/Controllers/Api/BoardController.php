<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BoardClick;
use App\Models\BoardItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function item(BoardItem $item)
    {
        $user = Auth::user();

        if (!$item->published_at && (!$user || $item->user_id != $user->id))
            abort(403);

        $hasClick = false;

        if ($user) {
            $hasClick = BoardClick::where('board_item_id', $item->id)
                    ->where('user_id', $user->id)
                    ->count() > 0;
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $item->id,
                'title' => $item->title,
                'item_type' => $item->item_type,
                'content' => $item->content,
                'published_at' => $item->published_at,
                'price' => [
                    'value' => $item->price_value,
                    'type' => $item->price_type,
                    'range' => $item->price_range
                ],
                'own' => $user && $item->user_id == $user->id,
                'hasClick' => $hasClick,
                'owner' => [
                    'id' => $item->user->id,
                    'name' => $item->user->name,
                    'email' => $hasClick ? $item->user->email : null
                ]
            ]
        ]);
    }

    public function click(Request $request, BoardItem $item)
    {
        $user = Auth::user();

        if (!$item->published_at || ($user && $item->user_id == $user->id))
            abort(403);

        $validated = $request->validate([
            'user_email' => [
                $user ? 'nullable' : 'required',
                'email'
            ],
            'user_name' => [
                $user ? 'nullable' : 'required',
                'string'
            ]
        ]);

        $click = new BoardClick([
            'board_item_id' => $item->id,
            'user_id' => $user?->id,
            'user_email' => !$user ? $validated['user_email'] : null,
            'user_name' => !$user ? $validated['user_name'] : null
        ]);

        $stored = $click->save();

        return response()->json($stored ? [
            'success' => true,
            'data' => [
                'owner_email' => $item->user->email
            ]
        ] : [ 'success' => false ]);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|unique:board_items,title|min:3',
            'content' => 'required|string|min:5',
            'price_value' => 'required|integer|min:0',
            'price_type' => [
                'required',
                'string',
                Rule::in(config('board.price_types'))
            ],
            'price_range' => [
                'required',
                'string',
                Rule::in(config('board.price_ranges'))
            ],
            'item_type' => [
                'required',
                'string',
                Rule::in(config('board.item_types'))
            ]
        ]);

        $item = new BoardItem(array_merge($validated, ['user_id' => $request->user()->id]));
        $stored = $item->save();

        return response()->json($stored ? [
            'success' => true,
            'data' => [
                'id' => $item->id
            ]
        ] : [
            'success' => false
        ]);
    }

    public function update(Request $request, BoardItem $item)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'min:3',
                $request->input('title') == $item->title ? '' : 'unique:board_items,title'
            ],
            'content' => 'required|string|min:5',
            'price_value' => 'required|integer|min:0',
            'price_type' => [
                'required',
                'string',
                Rule::in(config('board.price_types'))
            ],
            'price_range' => [
                'required',
                'string',
                Rule::in(config('board.price_ranges'))
            ],
            'item_type' => [
                'required',
                'string',
                Rule::in(config('board.item_types'))
            ]
        ]);

        return response()->json(['success' => $item->update($validated)]);
    }

    public function remove(BoardItem $item)
    {
        $item->removed_at = now();
        return response()->json(['success' => $item->save()]);
    }
}
