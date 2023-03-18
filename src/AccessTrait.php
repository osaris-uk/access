<?php

namespace OsarisUk\Access;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use OsarisUk\Access\Models\{Role, Permission};

/**
 * Trait AccessTrait
 * @package OsarisUk\Access
 */
trait AccessTrait
{
    public static function bootAccessTrait()
    {
        self::created(function ($user) {
            $user->giveRoles(config('access.default.roles'));
        });
    }

    /**
     * @param mixed ...$roles
     * @return $this
     */
    public function giveRoles(...$roles)
    {
        $roles = $this->getRoles(Arr::flatten($roles));

        if ($roles === null) {
            return $this;
        }

        $this->roles()->saveMany($roles);

        return $this;
    }

    /**
     * @param mixed ...$roles
     * @return $this
     */
    public function withdrawRoles(...$roles)
    {
        $roles = $this->getRoles(Arr::flatten($roles));

        $this->roles()->detach($roles);

        return $this;
    }

    /**
     * @param mixed ...$roles
     * @return AccessTrait
     */
    public function updateRoles(...$roles)
    {
        $this->roles()->detach();

        return $this->giveRoles($roles);
    }

    /**
     * @param mixed ...$permissions
     * @return $this
     */
    public function givePermissionTo(...$permissions)
    {
        $permissions = $this->getPermissions(Arr::flatten($permissions));

        if ($permissions === null) {
            return $this;
        }

        $this->permissions()->saveMany($permissions);

        return $this;
    }

    /**
     * @param mixed ...$permissions
     * @return $this
     */
    public function withdrawPermissionTo(...$permissions)
    {
        $permissions = $this->getPermissions(Arr::flatten($permissions));

        $this->permissions()->detach($permissions);

        return $this;
    }

    /**
     * @param mixed ...$permissions
     * @return AccessTrait
     */
    public function updatePermissions(...$permissions)
    {
        $this->permissions()->detach();

        return $this->givePermissionTo($permissions);
    }

    /**
     * @param mixed ...$roles
     * @return bool
     */
    public function hasRole(...$roles): bool
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('name', $role)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param array $roles
     * @return Collection
     */
    protected function getRoles(array $roles): Collection
    {
        return Role::whereIn('name', $roles)->get();
    }

    /**
     * @param $permission
     * @return bool
     */
    public function hasPermissionTo($permission): bool
    {
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }

    /**
     * @param array $permissions
     * @return Collection
     */
    protected function getPermissions(array $permissions): Collection
    {
        return Permission::whereIn('name', $permissions)->get();
    }

    /**
     * @param $permission
     * @return bool
     */
    protected function hasPermissionThroughRole($permission): bool
    {
        foreach ($this->roles as $role) {
            if ($role->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $permission
     * @return bool
     */
    protected function hasPermission(String $permission): bool
    {
        return (bool) $this->permissions->where('name', $permission)->count();
    }

    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'users_roles')->withTimestamps();
    }

    /**
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'users_permissions')->withTimestamps();
    }
}
