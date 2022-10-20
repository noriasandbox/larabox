<?php

namespace App\Models;

use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasLaraboxKeys;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory, SoftDeletes, HasAuthor, HasLaraboxKeys;

    const PREFIX = 'ROLE';

    protected $guarded = [];

    protected $hidden = [];

    protected $casts = [];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'roles_permissions')
            ->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_roles')
            ->withTimestamps();
    }

    public function getIsActiveAttribute()
    {
        return $this->deleted_at ? false : true;
    }
}
