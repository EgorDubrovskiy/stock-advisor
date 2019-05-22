<?php

namespace App\Interfaces\Services;

use Illuminate\Database\Eloquent\Collection;

/**
 * Interface CompanyInterface
 * @package App\Interfaces\Services
 */
interface CompanyInterface
{
    /**
     * @param array $parameters
     * @return Collection
     */
    public function getCompaniesForReport(array $parameters) : Collection;

    /**
     * @param string|null $date
     * @param array|null $parameters
     * @param int $limit
     * @return Collection
     */
    public function getTopCompanies(string $date = null, array $parameters = null, int $limit = 10) : Collection;

    /**
     * @param int $userId
     * @return Collection
     */
    public function getBookmarks(int $userId) : Collection;

    /**
     * @param array $parameters
     * @param int $itemsCount
     * @param int $pageNumber
     * @return Collection
     */
    public function searchGet(array $parameters, int $itemsCount = null, int $pageNumber = null) : Collection;

    public function searchCount(array $parameters, int $itemsCount = null, int $pageNumber = null) : int;
}
