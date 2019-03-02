<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tag
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|CompanyTag[] $companyTags
 */
class Tag extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];
}
