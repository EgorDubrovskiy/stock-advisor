<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Sector
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|Company[] $companies
 */
class Sector extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];

    public function companies()
    {
        return $this->hasMany(Company::class);
    }
}
