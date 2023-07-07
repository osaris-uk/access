<?php

namespace OsarisUk\Access\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Permission
 * @package OsarisUk\Access\Models
 * @property string $name
 */
class Permission extends Model
{
    /**
     * @var array<string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'roles_permissions')->withTimestamps();
    }
}
