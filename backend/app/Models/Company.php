<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Company
 * @package App\Models
 * @property int $id
 * @property int $industry_id
 * @property int $issue_type_id
 * @property int $sector_id
 * @property string $ceo
 * @property string $description
 * @property string $exchange
 * @property string $name
 * @property string $symbol
 * @property string $website
 * @property bool $is_enabled
 * @property string $created_at
 * @property-read Industry $industry
 * @property-read IssueType $issueType
 * @property-read Sector $sector
 * @property-read \Illuminate\Database\Eloquent\Collection|Tag[] $tags
 */
class Company extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'industry_id',
        'issue_type_id',
        'sector_id',
        'ceo',
        'description',
        'exchange',
        'name',
        'symbol',
        'website',
        'is_enabled',
        'created_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'bookmarks');
    }

    public function industries()
    {
        return $this->belongsTo(Industry::class, 'industry_id');
    }

    public function issueTypes()
    {
        return $this->belongsTo(IssueType::class, 'issue_type_id');
    }

    public function sectors()
    {
        return $this->belongsTo(Sector::class, 'sector_id');
    }
}
