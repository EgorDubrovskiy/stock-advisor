<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
use Carbon\Carbon;
use App\Models\Industry;
use App\Models\IssueType;
use App\Models\Sector;

/**
 * Class CompanySeeder
 */
class CompanySeeder extends Seeder
{
    /**
     * @throws Exception
     */
    public function run()
    {
        $companies = [
            [
                'symbol' => 'IBM',
                'name' => 'International Business Machines Corporation',
                'exchange' => 'New York Stock Exchange',
                'website' => 'http://www.ibm.com',
                'description' => 'Some description.',
                'ceo' => 'Virginia M. Rometty',
                'is_enabled' => '1',
                'industry' => 'Application Software',
                'issueType' => 'cs',
                'sector' => 'Technology',
            ],
            [
                'symbol' => 'AAPL',
                'name' => 'Apple Inc.',
                'exchange' => 'Nasdaq Global Select',
                'website' => 'http://www.apple.com',
                'description' => 'Some description.',
                'ceo' => 'Timothy D. Cook',
                'is_enabled' => '1',
                'industry' => 'Computer Hardware',
                'issueType' => 'cs',
                'sector' => 'Technology',
            ],
            [
                'symbol' => 'SNAP',
                'name' => 'Snap Inc. Class A',
                'exchange' => 'New York Stock Exchange',
                'website' => 'http://www.snap.com',
                'description' => 'Some description.',
                'ceo' => 'Evan Spiegel',
                'is_enabled' => '1',
                'industry' => 'Online Media',
                'issueType' => 'cs',
                'sector' => 'Technology',
            ],
            [
                'symbol' => 'TWTR',
                'name' => 'Twitter Inc.',
                'exchange' => 'New York Stock Exchange',
                'website' => 'https://www.twitter.com',
                'description' => 'Some description.',
                'ceo' => 'Jack Dorsey',
                'is_enabled' => '1',
                'industry' => 'Online Media',
                'issueType' => 'cs',
                'sector' => 'Technology',
            ],
            [
                'symbol' => 'DIS',
                'name' => 'The Walt Disney Company',
                'exchange' => 'New York Stock Exchange',
                'website' => 'http://www.disney.com',
                'description' => 'Some description.',
                'ceo' => 'Robert A. Iger',
                'is_enabled' => '1',
                'industry' => 'Entertainment',
                'issueType' => 'cs',
                'sector' => 'Consumer Cyclical',
            ],
            [
                'symbol' => 'PXR',
                'name' => 'Invesco Emerging Markets Infrastructure',
                'exchange' => 'NYSE Arca',
                'website' => 'http://www.invescopowershares.com',
                'description' => 'Some description.',
                'ceo' => 'Unknown',
                'is_enabled' => '1',
                'industry' => 'Unknown',
                'issueType' => 'et',
                'sector' => 'Unknown',
            ],
            [
                'symbol' => 'MCD',
                'name' => 'McDonald\'s Corporation',
                'exchange' => 'New York Stock Exchange',
                'website' => 'http://www.aboutmcdonalds.com',
                'description' => 'Some description.',
                'ceo' => 'Stephen Easterbrook',
                'is_enabled' => '1',
                'industry' => 'Restaurants',
                'issueType' => 'cs',
                'sector' => 'Consumer Cyclical',
            ],
            [
                'symbol' => 'SBUX',
                'name' => 'Starbucks Corporation',
                'exchange' => 'Nasdaq Global Select',
                'website' => 'http://www.starbucks.com',
                'description' => 'Some description.',
                'ceo' => 'Kevin R. Johnson',
                'is_enabled' => '1',
                'industry' => 'Restaurants',
                'issueType' => 'cs',
                'sector' => 'Consumer Cyclical',
            ],
            [
                'symbol' => 'ERIC',
                'name' => 'Ericsson',
                'exchange' => 'Nasdaq Global Select',
                'website' => 'http://www.ericsson.com',
                'description' => 'Some description.',
                'ceo' => 'Borje Ekholm',
                'is_enabled' => '1',
                'industry' => 'Communication Equipment',
                'issueType' => 'cs',
                'sector' => 'Technology',
            ],
            [
                'symbol' => 'FOX',
                'name' => 'Twenty-First Century Fox Inc.',
                'exchange' => 'Nasdaq Global Select',
                'website' => 'http://www.21cf.com',
                'description' => 'Some description.',
                'ceo' => 'James R. Murdoch',
                'is_enabled' => '1',
                'industry' => 'Entertainment',
                'issueType' => 'cs',
                'sector' => 'Consumer Cyclical',
            ],
            [
                'symbol' => 'MSFT',
                'name' => 'Microsoft Corporation',
                'exchange' => 'Nasdaq Global Select',
                'website' => 'http://www.microsoft.com',
                'description' => 'Some description.',
                'ceo' => 'Satya Nadella',
                'is_enabled' => '1',
                'industry' => 'Application Software',
                'issueType' => 'cs',
                'sector' => 'Technology',
            ],
            [
                'symbol' => 'AMZN',
                'name' => 'Amazon.com Inc.',
                'exchange' => 'Nasdaq Global Select',
                'website' => 'http://www.amazon.com',
                'description' => 'Some description.',
                'ceo' => 'Jeffrey P. Bezos',
                'is_enabled' => '1',
                'industry' => 'Retail - Apparel & Specialty',
                'issueType' => 'cs',
                'sector' => 'Consumer Cyclical',
            ],
            [
                'symbol' => 'DNKN',
                'name' => 'Dunkin\' Brands Group Inc.',
                'exchange' => 'Nasdaq Global Select',
                'website' => 'http://www.dunkinbrands.com',
                'description' => 'Some description.',
                'ceo' => 'David L. Hoffmann',
                'is_enabled' => '1',
                'industry' => 'Restaurants',
                'issueType' => 'cs',
                'sector' => 'Consumer Cyclical',
            ],
            [
                'symbol' => 'KO',
                'name' => 'Coca-Cola Company (The)',
                'exchange' => 'New York Stock Exchange',
                'website' => 'http://www.coca-colacompany.com',
                'description' => 'Some description.',
                'ceo' => 'James Robert Quincey',
                'is_enabled' => '1',
                'industry' => 'Beverages - Non-Alcoholic',
                'issueType' => 'cs',
                'sector' => 'Consumer Defensive',
            ],
            [
                'symbol' => 'YUM',
                'name' => 'Yum! Brands Inc.',
                'exchange' => 'New York Stock Exchange',
                'website' => 'http://www.yum.com',
                'description' => 'Some description.',
                'ceo' => 'Greg Creed',
                'is_enabled' => '1',
                'industry' => 'Restaurants',
                'issueType' => 'cs',
                'sector' => 'Consumer Cyclical',
            ],
        ];
        foreach ($companies as $company) {
            try {
                $newCompany = new Company();
                $newCompany->fill([
                    'symbol' => $company['symbol'],
                    'name' => $company['name'],
                    'exchange' => $company['exchange'],
                    'website' => $company['website'],
                    'description' => $company['description'],
                    'ceo' => $company['ceo'],
                    'is_enabled' => $company['is_enabled'],
                    'created_at' => Carbon::now(),
                ]);
                $industry = Industry::firstOrCreate([
                    'name' => $company['industry'],
                ]);
                $newCompany->industries()->associate($industry);
                $issueType = IssueType::firstOrCreate([
                    'description' => $company['issueType'],
                ]);
                $newCompany->issueTypes()->associate($issueType);
                $sector = Sector::firstOrCreate([
                    'name' => $company['sector'],
                ]);
                $newCompany->sectors()->associate($sector);
                $newCompany->save();
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }
    }
}
