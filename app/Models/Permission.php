<?php

namespace App\Models;

use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasLaraboxKeys;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory, SoftDeletes, HasAuthor, HasLaraboxKeys;

    const PREFIX = 'PERM';

    protected $guarded = [];

    protected $hidden = [];

    protected $casts = [];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_permissions')
            ->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_permissions')
            ->withTimestamps();
    }
}
