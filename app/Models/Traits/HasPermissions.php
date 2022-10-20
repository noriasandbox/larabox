<?php

namespace App\Models\Traits;

use App\Models\Permission;
use App\Models\Role;

trait HasPermissions
{
    // roles
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles')
            ->withTimestamps();
    }

    // permissions
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions')
            ->withTimestamps();
    }

    //ve permissions
    public function givePermissions(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        if ($permissions === null) {
            return $this;
        }
        $this->permissions()->saveMany($permissions);
        return $this;
    }

    // give roles
    public function giveRoles(...$roles)
    {
        $roles = $this->getAllRoles($roles);
        if ($roles === null) {
            return $this;
        }
        $this->roles()->saveMany($roles);
        return $this;
    }

    // withdraw permissions
    public function withdrawPermissions(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        $this->permissions()->detach($permissions);
        return $this;
    }

    // withdraw roles
    public function withdrawRoles(...$roles)
    {
        $roles = $this->getAllRoles($roles);
        $this->roles()->detach($roles);
        return $this;
    }

    // refresh permissions
    public function refreshPermissions(...$permissions)
    {
        $this->permissions()->detach();
        return $this->givePermissions($permissions);
    }

    // refresh roles
    public function refreshRoles(...$roles)
    {
        $this->roles()->detach();
        return $this->giveRoles($roles);
    }

    // has permission
    public function hasPermission($permission): bool
    {
        return $this->hasPermissionThroughRole($permission) || $this->hasDirectPermission($permission);
    }

    // has permission through roles
    public function hasPermissionThroughRole($permission): bool
    {
        foreach ($permission->roles as $role) {
            if ($this->roles->contains($role)) {
                return true;
            }
        }
        return false;
    }

    // has direct permissions
    protected function hasDirectPermission($permission): bool
    {
        return (bool) $this->permissions()->where('name', $permission->name)->count();
    }

    // has any of the roles
    public function hasAnyRole(...$roles): bool
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('name', $role)) {
                return true;
            }
        }
        return false;
    }

    // has role
    public function hasRole($role): bool
    {
        return (bool) $this->roles->contains('name', $role);
    }

    // get all permissions
    protected function getAllPermissions(array $permissions)
    {
        return Permission::query()->whereIn('name', $permissions)->get();
    }

    // get all roles
    protected function getAllRoles(array $roles)
    {
        return Role::query()->whereIn('name', $roles)->get();
    }
}
