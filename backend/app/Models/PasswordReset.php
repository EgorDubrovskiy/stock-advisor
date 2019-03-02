<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PasswordReset
 * @package App\Models
 * @property int $user_id
 * @property string $token
 * TODO: коль тип DateTime где же тогда cast на него https://laravel.com/docs/5.7/eloquent-mutators
 * @property \DateTime $created_at
 * @property-read User $user
 */
class PasswordReset extends Model
{
    public $timestamps = true;

    public $updated_at = true;

    protected $fillable = ['user_id', 'token'];
}
