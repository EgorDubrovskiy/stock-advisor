<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

/**
 * Class CompanyTest
 * @package Tests\Feature
 */
class CompanyTest extends TestCase
{
    public function testUniqueSymbolError()
    {
        $response = $this->post('api/companies', [
            'symbol' => 'IBM',
            'name' => 'International Business Machines Corporation',
            'exchange' => 'New York Stock Exchange',
            'website' => 'http://www.ibm.com',
            'description' => 'Some description.',
            'ceo' => 'Virginia M. Rometty',
            'is_enabled' => '1',
            'industry' => 'Application Software',
            'issue_type' => 'cs',
            'sector' => 'Technology',
        ]);

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
        $response->assertJson([
            'error' => [
                'symbol' => 'The symbol has already been taken.',
            ]
        ]);
    }

    /**
     * @param string $key
     * @param string $error
     * @dataProvider requiredProvider
     */
    public function testRequiredError(string $key, string $error)
    {
        $company = [
            'symbol' => 'WMT',
            'name' => 'Walmart Inc.',
            'exchange' => 'New York Stock Exchange',
            'website' => 'http://www.walmart.com',
            'description' => 'Some description.',
            'ceo' => 'C. Douglas McMillon',
            'is_enabled' => '1',
            'industry' => 'Retail - Defensive',
            'issue_type' => 'cs',
            'sector' => 'Consumer Defensive',
        ];
        unset($company[$key]);

        $response = $this->post('api/companies', $company);
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
        $response->assertJson([
            'error' => [
                $key => $error,
            ]
        ]);
    }

    public function requiredProvider()
    {
        return [
            ['symbol', 'The symbol field is required.'],
            ['name', 'The name field is required.'],
            ['exchange', 'The exchange field is required.'],
            ['website', 'The website field is required.'],
            ['ceo', 'The ceo field is required.'],
            ['is_enabled', 'The is enabled field is required.'],
            ['industry', 'The industry field is required.'],
            ['issue_type', 'The issue type field is required.'],
            ['sector', 'The sector field is required.'],
        ];
    }



    /**
     * @param string $key
     * @param string $error
     * @dataProvider maxSizeProvider
     */
    public function testMaxSizeError(string $key, string $error)
    {
        $company = [
            'symbol' => 'WMT',
            'name' => 'Walmart Inc.',
            'exchange' => 'New York Stock Exchange',
            'website' => 'http://www.walmart.com',
            'description' => 'Some description.',
            'ceo' => 'C. Douglas McMillon',
            'is_enabled' => '1',
            'industry' => 'Retail - Defensive',
            'issue_type' => 'cs',
            'sector' => 'Consumer Defensive',
        ];

        $company[$key] = str_repeat('a', 256);
        $response = $this->post('api/companies', $company);
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
        $response->assertJson([
            'error' => [
                $key => $error,
            ]
        ]);
    }

    public function maxSizeProvider()
    {
        return [
            ['symbol', 'The symbol may not be greater than 8 characters.'],
            ['name', 'The name may not be greater than 255 characters.'],
            ['exchange', 'The exchange may not be greater than 255 characters.'],
            ['website', 'The website may not be greater than 180 characters.'],
            ['ceo', 'The ceo may not be greater than 64 characters.'],
            ['is_enabled', 'The is enabled must be 1 characters.'],
        ];
    }

    public function testCreatingCompanySuccessResponse()
    {
        $response = $this->post('api/companies', [
            'symbol' => 'WMT',
            'name' => 'Walmart Inc.',
            'exchange' => 'New York Stock Exchange',
            'website' => 'http://www.walmart.com',
            'description' => 'Some description.',
            'ceo' => 'C. Douglas McMillon',
            'is_enabled' => '1',
            'industry' => 'Retail - Defensive',
            'issue_type' => 'cs',
            'sector' => 'Consumer Defensive',
        ]);

        $response->assertSuccessful();

        $response->assertJson([
            'data' => [
                'company' => [
                    'symbol' => 'WMT',
                    'name' => 'Walmart Inc.',
                    'exchange' => 'New York Stock Exchange',
                    'website' => 'http://www.walmart.com',
                    'description' => 'Some description.',
                    'ceo' => 'C. Douglas McMillon',
                    'is_enabled' => '1',
                    'industries' => [
                        'name' => 'Retail - Defensive',
                    ],
                    'issue_types' => [
                        'description' => 'cs',
                    ],
                    'sectors' => [
                        'name' => 'Consumer Defensive',
                    ],
                ]
            ]
        ]);
    }

    public function testCompanySavedCorrectly()
    {
        $this->assertDatabaseHas('companies', [
            'symbol' => 'WMT',
            'name' => 'Walmart Inc.',
            'exchange' => 'New York Stock Exchange',
            'website' => 'http://www.walmart.com',
            'description' => 'Some description.',
            'ceo' => 'C. Douglas McMillon',
            'is_enabled' => '1',
        ]);

        $company = Company::where('symbol', 'WMT')->first();

        $this->assertDatabaseHas('industries', [
            'id' => $company->industry_id,
            'name' => 'Retail - Defensive',
        ]);

        $this->assertDatabaseHas('issue_types', [
            'id' => $company->issue_type_id,
            'description' => 'cs'
        ]);

        $this->assertDatabaseHas('sectors', [
            'id' => $company->sector_id,
            'name' => 'Consumer Defensive',
        ]);
    }

    public function testCompanyDeletedCorrectly()
    {
        $userId = User::where('login', 'testCreateBookmarkUser')->first()->id;
        $companyId = Company::where('symbol', 'WMT')->first()->id;

        $this->post('api/bookmarks/' . $userId . '/' . $companyId)->assertSuccessful();

        $response = $this->delete('api/companies/' . $companyId);
        $response->assertSuccessful();
        $response->assertJson([
            'data' => [
                $companyId => 'Company was deleted.',
            ]
        ]);

        $this->assertSoftDeleted('companies', [
            'id' => $companyId,
        ]);

        $this->assertSoftDeleted('bookmarks', [
            'user_id' => $userId,
            'company_id' => $companyId,
        ]);

        $response = $this->delete('api/companies/' . $companyId);
        $response->assertStatus(JsonResponse::HTTP_NOT_FOUND);
        $response->assertJson([
            'error' => [
                'error' => 'Model Not Found',
            ]
        ]);
    }
}
