<?php

namespace OsarisUk\Access\Models;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * @package OsarisUk\Access\Models
 */
class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

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
     * @return $this
     */
    public function updatePermissions(...$permissions)
    {
        $this->permissions()->detach();

        return $this->givePermissionTo($permissions);
    }

    /**
     * @param array $permissions
     * @return mixed
     */
    protected function getPermissions(array $permissions)
    {
        return Permission::whereIn('name', $permissions)->get();
    }

    /**
     * @param $permission
     * @return bool
     */
    public function hasPermission(String $permission)
    {
        return (bool) $this->permissions->where('name', $permission)->count();
    }

    /**
     * @return mixed
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'roles_permissions')->withTimestamps();
    }
}
