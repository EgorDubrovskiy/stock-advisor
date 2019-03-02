<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property-read Illuminate\Database\Eloquent\Collection|UserRole[] $userRoles
 * @property-read Illuminate\Database\Eloquent\Collection|User[] $users
 */
class Role extends Model
{
    /** @var bool $timestamps */
    public $timestamps = false;

    /** @var array $fillable */
    protected $fillable = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userRoles()
    {
        return $this->hasMany(UserRole::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
