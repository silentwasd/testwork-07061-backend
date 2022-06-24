<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Searchable;

class BoardItem extends Model
{
    use HasFactory, Searchable;

    protected $casts = [
        'published_at' => 'datetime'
    ];

    protected $fillable = [
        'user_id', 'title', 'content', 'price_type', 'price_value', 'price_range', 'item_type'
    ];

    #[SearchUsingFullText(['content'])]
    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'item_type' => $this->item_type,
            'published_at' => $this->published_at,
        ];
    }

    public function shouldBeSearchable(): bool
    {
        return $this->published_at && !$this->removed_at;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
