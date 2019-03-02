<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class IssueType
 * @package App\Models
 * @property int $id
 * @property string $description
 * @property-read Illuminate\Database\Eloquent\Collection|Company[] $companies
 */
class IssueType extends Model
{
    public $timestamps = false;

    protected $fillable = ['description'];

    public function companies()
    {
        return $this->hasMany(Company::class);
    }
}
