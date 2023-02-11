<?php

namespace OsarisUk\Access\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Permission
 * @package OsarisUk\Access\Models
 */
class Permission extends Model
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
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_permissions')->withTimestamps();
    }
}
