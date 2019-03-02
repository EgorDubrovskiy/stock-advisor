<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Price
 * @package App\Models
 * @property int $id
 * @property int $company_id
 * @property double $price
 * TODO: такого типа timestamp нет
 * @property timestamp $created_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Company[] $companies
 */
class Price extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

}
