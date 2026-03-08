<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeachImage extends Model
{
    public function beach()
    {
        return $this->belongsTo(Beach::class);
    }

    public function user()
    {
        $this->belongsTo(User::class);
    }
}
