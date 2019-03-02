<?php

namespace App\Services\Database;

use App\Models\Company;
use App\Models\Bookmark;
use App\Models\IssueType;
use App\Models\Sector;
use Carbon\Carbon;
use App\Models\Industry;
use Illuminate\Support\Facades\DB;
use Exception;

/**
 * Class CompanyService
 * @package App\Services\Database
 */
class CompanyService
{

    public function add(array $newCompany) : Company
    {
        DB::beginTransaction();

        try {
            $newCompany['created_at'] = Carbon::now();

            $company = new Company();
            $company->fill($newCompany);

            $industry = Industry::firstOrCreate(['name' => $newCompany['industry']]);
            $company->industries()->associate($industry);

            $issueType = IssueType::firstOrCreate(['description' => $newCompany['issue_type']]);
            $company->issueTypes()->associate($issueType);

            $sector = Sector::firstOrCreate(['name' => $newCompany['sector']]);
            $company->sectors()->associate($sector);

            $company->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $company;
    }


    /**
     * @param int $id
     * @throws Exception
     */
    public function delete(int $id) : void
    {
        DB::beginTransaction();

        try {
            Company::where('id', $id)->delete();
            Bookmark::where('company_id', $id)->delete();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
