<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beach extends Model
{
    /** @use HasFactory<\Database\Factories\BeachFactory> */
    use HasFactory;

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function images()
    {
        return $this->hasMany(BeachImage::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class);
    }

    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

}
