<?php

namespace Tests\Feature;

use Illuminate\Http\JsonResponse;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

/**
 * Class AddCompanyToBookmarkTest
 * @package Tests\Feature
 */
class AddCompanyToBookmarkTest extends TestCase
{
    public function testAddCompany()
    {
        $user = DB::table('users')
            ->latest('id')
            ->first();

        $company = DB::table('companies')
            ->latest('id')
            ->first();

        $userId = $user->id;
        $companyId = $company->id;
        $invalidUserId = $userId + 10;
        $invalidCompanyId = $companyId + 10;

        $response = $this->json('POST', "api/bookmarks/$userId/$companyId");

        $response
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJson([]);

        $invalidResponse = $this->json('POST', "api/bookmarks/$invalidUserId/$companyId");

        $invalidResponse
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND);

        $invalidResponse = $this->json('POST', "api/bookmarks/$userId/$invalidCompanyId");

        $invalidResponse
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND);
    }
}
