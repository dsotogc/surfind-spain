<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function beach()
    {
        return $this->belongsTo(Beach::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
