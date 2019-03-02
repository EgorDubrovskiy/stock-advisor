<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property int $id
 * @property string $login
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property string $secret_key
 * @property string $profile_picture
 * @property-read \Illuminate\Database\Eloquent\Collection|Bookmark[] $bookmarks
 * @property-read \Illuminate\Database\Eloquent\Collection|PasswordReset[] $passwordResets
 * @property-read \Illuminate\Database\Eloquent\Collection|Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|Role[] $priceNotifications
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['login', 'password', 'email'];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return int
     */
    public function getJWTIdentifier() : int
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() : array
    {
        $roles = $this->roles()->get()->pluck('name')->toArray();

        return [
            'roles' => $roles
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'bookmarks');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function priceNotifications()
    {
        return $this->hasMany(PriceNotification::class);
    }
}
