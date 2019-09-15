<?php

namespace OsarisUk\Access;

use Illuminate\Support\Arr;
use OsarisUk\Access\Models\{Role, Permission};

trait AccessTrait
{
    public static function bootAccessTrait()
    {
        self::created(function ($user) {
            $user->giveRoles(config('access.default.role'));
        });
    }

    public function giveRoles(...$roles)
    {
        $roles = $this->getRoles(Arr::flatten($roles));

        if ($roles === null) {
            return $this;
        }

        $this->roles()->saveMany($roles);

        return $this;
    }

    public function withdrawRoles(...$roles)
    {
        $roles = $this->getRoles(Arr::flatten($roles));

        $this->roles()->detach($roles);

        return $this;
    }

    public function updateRoles(...$roles)
    {
        $this->roles()->detach();

        return $this->giveRoles($roles);
    }

    public function givePermissionTo(...$permissions)
    {
        $permissions = $this->getPermissions(Arr::flatten($permissions));

        if ($permissions === null) {
            return $this;
        }

        $this->permissions()->saveMany($permissions);

        return $this;
    }

    public function withdrawPermissionTo(...$permissions)
    {
        $permissions = $this->getPermissions(Arr::flatten($permissions));

        $this->permissions()->detach($permissions);

        return $this;
    }

    public function updatePermissions(...$permissions)
    {
        $this->permissions()->detach();

        return $this->givePermissionTo($permissions);
    }

    public function hasRole(...$roles)
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('name', $role)) {
                return true;
            }
        }
        return false;
    }

    protected function getRoles(array $roles)
    {
        return Role::whereIn('name', $roles)->get();
    }

    public function hasPermissionTo($permission)
    {
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }

    protected function getPermissions(array $permissions)
    {
        return Permission::whereIn('name', $permissions)->get();
    }

    protected function hasPermissionThroughRole($permission)
    {
        foreach ($permission->roles as $role) {
            if ($this->roles->contains($role)) {
                return true;
            }
        }

        return false;
    }

    protected function hasPermission($permission)
    {
        return (bool) $this->permissions->where('name', $permission->name)->count();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles')->withTimestamps();
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions')->withTimestamps();
    }
}