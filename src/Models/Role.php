<?php

namespace OsarisUk\Access\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class Role
 * @package OsarisUk\Access\Models
 * @property string $name
 */
class Role extends Model
{
    /**
     * @var array<string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * @param mixed ...$permissions
     */
    public function givePermissionTo(...$permissions): Role
    {
        $permissions = $this->getPermissions(Arr::flatten($permissions));

        if (! $permissions->count()) {
            return $this;
        }

        $this->permissions()->saveMany($permissions);

        return $this;
    }

    /**
     * @param mixed ...$permissions
     */
    public function withdrawPermissionTo(...$permissions): Role
    {
        $permissions = $this->getPermissions(Arr::flatten($permissions));

        $this->permissions()->detach($permissions);

        return $this;
    }

    /**
     * @param mixed ...$permissions
     */
    public function updatePermissions(...$permissions): Role
    {
        $this->permissions()->detach();

        return $this->givePermissionTo($permissions);
    }

    /**
     * @param array<string> $permissions
     * @return Collection
     */
    protected function getPermissions(array $permissions): Collection
    {
        return Permission::whereIn('name', $permissions)->get();
    }

    public function hasPermission(string $permission): bool
    {
        return (bool) $this->permissions->where('name', $permission)->count();
    }

    /**
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'roles_permissions')->withTimestamps();
    }
}
