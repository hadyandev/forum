<?php

namespace App;

use App\Favorite;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];
        // bisa memfavoritkan reply jika sebelumnya belum pernah memfavoritkan reply tersebut
        if (!$this->favorites()->where(['user_id' => $attributes])->exists()) {
            return $this->favorites()->create($attributes);
        }
    }
}
