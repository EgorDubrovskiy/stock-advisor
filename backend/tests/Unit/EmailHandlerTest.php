<?php

namespace Tests\Unit;

use App\Events\CriticalLogEvent;
use App\Events\EmergencyLogEvent;
use App\Handlers\EmailHandler;
use Tests\TestCase;
use Illuminate\Support\Facades\Event;

/**
 * Class EmailHandlerTest
 * @package Tests\Unit
 */
class EmailHandlerTest extends TestCase
{
    public function testEmailHandler() {
        Event::fake([
            EmergencyLogEvent::class,
            CriticalLogEvent::class
        ]);

        $recordEmergency = [
            'message' => 'error',
            'context' => [],
            'level' => 600,
            'level_name' => 'EMERGENCY',
            'channel' => 'local',
            'datetime' => [],
            'extra' => []
        ];

        $recordCritical = [
            'message' => 'error',
            'context' => [],
            'level' => 500,
            'level_name' => 'CRITICAL',
            'channel' => 'local',
            'datetime' => [],
            'extra' => []
        ];

        $invalidRecord = [
            'message' => 'debug',
            'context' => [],
            'level' => 100,
            'level_name' => 'DEBUG',
            'channel' => 'local',
            'datetime' => [],
            'extra' => []
        ];

        $emailHandler = new EmailHandler();

        $result = $emailHandler->handle($recordEmergency);

        $this->assertEquals(true, $result);

        $result = $emailHandler->handle($recordCritical);

        $this->assertEquals(true, $result);

        $result = $emailHandler->handle($invalidRecord);

        $this->assertEquals(false, $result);

        Event::assertDispatched(EmergencyLogEvent::class);

        Event::assertDispatched(CriticalLogEvent::class);
    }
}
