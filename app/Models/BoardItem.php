<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Searchable;

class BoardItem extends Model
{
    use HasFactory, Searchable;

    protected $casts = [
        'published_at' => 'datetime'
    ];

    #[SearchUsingFullText(['content'])]
    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
            'published_at' => $this->published_at,
        ];
    }

    public function shouldBeSearchable(): bool
    {
        return $this->published_at && !$this->removed_at;
    }
}
