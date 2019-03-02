<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Bookmark
 * @package App\Models
 * @property int $id_user
 * @property int $id_company
 * @property-read User $user
 * @property-read Company $company
 * @property array $fillable
 * @property bool $timestamps
 */
class Bookmark extends Model
{
    use SoftDeletes;

    /** @var bool $timestamps */
    public $timestamps = false;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /** @var array $fillable */
    protected $fillable = [
        'user_id',
        'company_id'
    ];

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
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
