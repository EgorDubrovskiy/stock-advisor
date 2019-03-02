<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Industry
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|Company[] $companies
 */
class Industry extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];

    public function companies()
    {
        return $this->hasMany(Company::class);
    }
}
