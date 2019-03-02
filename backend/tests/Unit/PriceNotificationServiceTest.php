<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\PriceNotification;
use App\Services\Models\PriceNotificationService;
use App\Factory\PriceNotificationFactory;
use Mockery;


/**
 * Class PriceNotificationServiceTest
 * @package Tests\Unit
 */
class PriceNotificationServiceTest extends TestCase
{
    public function testCreateSuccess()
    {
        $fields = [
            'type' => '>',
            'company_id' => 10,
            'price' => 65.4,
            'user_id' => 1
        ];
        $mockPriceNotification = Mockery::mock(PriceNotification::class);
        $mockPriceNotificationFactory = Mockery::mock(PriceNotificationFactory::class);
        $mockPriceNotificationFactory
            ->shouldReceive('makePriceNotification')
            ->once()
            ->with($fields)
            ->andReturn($mockPriceNotification);
        $mockPriceNotification
            ->shouldReceive('save')
            ->once()
            ->withNoArgs();
        $mockPriceNotificationService = new PriceNotificationService($mockPriceNotificationFactory);
        $mockPriceNotificationService->create($fields);
    }

   public function  testUpdateSuccess()
   {
       $fields = [
           'type' => '>',
           'company_id' => 10,
           'price' => 65.4,
       ];
       $mockPriceNotification = Mockery::mock(PriceNotification::class);
       $mockPriceNotification->shouldReceive('fill')
           ->once()
           ->with($fields)
           ->andReturn();
       $mockPriceNotification->shouldReceive('save')
           ->once()
           ->withNoArgs()
           ->andReturn();
       $mockPriceNotificationFactory = Mockery::mock(PriceNotificationFactory::class);
       $mockPriceNotificationService = new PriceNotificationService($mockPriceNotificationFactory);
       $mockPriceNotificationService->update($mockPriceNotification, $fields);
   }

    /**
     * @throws \Exception
     */
    public function testDeleteSuccess()
    {
        $mockPriceNotification = Mockery::mock(PriceNotification::class);
        $mockPriceNotification->shouldReceive('delete')
            ->once()
            ->withNoArgs()
            ->andReturn();
        $mockPriceNotificationFactory = Mockery::mock(PriceNotificationFactory::class);
        $mockPriceNotificationService = new PriceNotificationService($mockPriceNotificationFactory);
        $mockPriceNotificationService->delete($mockPriceNotification);
    }
}
