<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BoardClick extends Model
{
    public $fillable = [
        'user_id', 'board_item_id', 'user_name', 'user_email'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
