<?php

namespace App\Handlers;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use App\Events\EmergencyLogEvent;
use App\Events\CriticalLogEvent;

/**
 * Class EmailHandler
 * @package App\Handlers
 */
class EmailHandler extends AbstractProcessingHandler
{

    /**
     * EmailHandler constructor.
     * @param int $level
     */
    public function __construct($level = Logger::DEBUG) {

        parent::__construct($level, true);

    }

    /** @param array $record */
    public function write(array $record)
    {

    }

    /**
     * @param array $record
     * @return bool
     */
    public function handle(array $record) : bool
    {
        if ($record['level'] === Logger::EMERGENCY) {
            event(new EmergencyLogEvent($record['message']));
            return true;
        }

        if($record['level'] === Logger::CRITICAL) {
            event(new CriticalLogEvent($record['message']));
            return true;
        }

        return false;
    }
}
