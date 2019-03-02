<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PriceController
 * @package App\Models
 * @property int $user_id
 * @property int $company_id
 * @property-read User $user
 * @property-read Company $company
 * @property bool $timestamps
 */
class PriceNotification extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected  $fillable = ['user_id', 'type', 'price', 'company_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
