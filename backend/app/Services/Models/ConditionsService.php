<?php

namespace App\Services\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class ConditionsService
 * @package App\Services\Models
 */
class ConditionsService
{
    /**
     * @var array SEARCHPARAMETERS
     * @todo Settings names of search parameters
     */
    const SEARCHPARAMETERS = [
        'beginLike' => 'beginLike'
    ];

    /**
     * @var array SORTINGPARAMETERS
     * @todo Settings names of sorting parameters
     */
    const SORTINGPARAMETERS = [
        'asc' => 'asc',
        'desc' => 'desc',
        'default' => 'asc'
    ];

    /**
     * @param Builder $builder
     * @param string $parameter
     * @param string $column
     * @param string $value
     * @return Builder
     */
    public function addWhere(Builder $builder, string $parameter, string $column, string $value) : Builder
    {
        switch ($parameter) {
            case self::SEARCHPARAMETERS['beginLike']:
                $builder->where($column, 'like', $value . '%');
                break;
        }

        return $builder;
    }

    /**
     * @param Builder $builder
     * @param string $column
     * @param string $parameter
     * @return Builder
     */
    public function addOrderBy(
        Builder $builder,
        string $column,
        string $parameter = self::SORTINGPARAMETERS['default']
    ) : Builder {
        switch ($parameter) {
            case self::SORTINGPARAMETERS['asc']:
                $builder->orderBy($column, 'ASC');
                break;
            case self::SORTINGPARAMETERS['desc']:
                $builder->orderBy($column, 'DESC');
                break;
        }

        return $builder;
    }

    /**
     * @param Builder $builder
     * @param int $itemsCount
     * @param int $pageNumber
     * @return Builder
     */
    public function addPagination(Builder $builder, int $itemsCount, int $pageNumber = 1) : Builder
    {
        $builder->limit($itemsCount);
        $builder->offset($itemsCount * ($pageNumber - 1));

        return $builder;
    }
}
