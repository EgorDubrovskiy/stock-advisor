<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CompanyTag
 * @package App\Models
 * @property int $company_id
 * @property int $tag_id
 * TODO: комментарии есть, а где сами связи?
 * @property-read Company $company
 * @property-read Tag $tag
 */
class CompanyTag extends Model
{
    public $timestamps = false;

    protected $fillable = ['company_id', 'tag_id'];
}
