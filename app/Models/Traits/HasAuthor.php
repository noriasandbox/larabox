<?php

namespace App\Models\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


trait HasAuthor
{
    protected static function bootHasAuthor()
    {
        if (Auth::check()) {
            static::creating(function (Model $model) {
                $model->author_id = Auth::id();
            });
        }
    }

    // author
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
