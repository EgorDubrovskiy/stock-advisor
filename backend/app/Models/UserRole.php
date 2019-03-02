<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserRole
 * @package App\Models
 * @property int $user_id
 * @property int $role_id
 * @property-read User $user
 * @property-read Role $role
 */
class UserRole extends Model
{
    /** @var bool $timestamps */
    public $timestamps = false;

    /** @var array $fillable */
    protected $fillable = ['user_id', 'role_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
