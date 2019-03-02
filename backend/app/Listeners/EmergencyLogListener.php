<?php

namespace App\Listeners;

use App\Jobs\SendMail;
use App\Events\EmergencyLogEvent;

/**
 * Class EmergencyLogListener
 * @package App\Listeners
 */
class EmergencyLogListener
{
    /**
     * @param EmergencyLogEvent $event
     */
    public function handle(EmergencyLogEvent $event)
    {
        $userEmail = config('logNotificationEmergencyEmail.LOG_NOTIFICATION_EMERGENCY_EMAIL');
        $subject = 'Emergency Notification';
        $message = 'Error: '.$event->message.' The system is down!';

        SendMail::dispatch($userEmail, $subject, $message);
    }
}
