<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardClick extends Model
{
    public $fillable = [
        'user_id', 'board_item_id', 'user_name', 'user_email'
    ];
}
