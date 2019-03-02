<?php

namespace App\Listeners;

use App\Jobs\SendMail;
use App\Events\CriticalLogEvent;

/**
 * Class CriticalLogListener
 * @package App\Listeners
 */
class CriticalLogListener
{
    /**
     * @param CriticalLogEvent $event
     */
    public function handle(CriticalLogEvent $event)
    {
        $userEmailEmergency = config('logNotificationEmergencyEmail.LOG_NOTIFICATION_EMERGENCY_EMAIL');
        $userEmailCritical = config('logNotificationCriticalEmail.LOG_NOTIFICATION_CRITICAL_EMAIL');
        $subject = 'Critical Notification';
        $message = 'Error: '.$event->message.' Critical conditions. (Application component unavailable, unexpected exception.)';

        SendMail::dispatch($userEmailCritical, $subject, $message, $userEmailEmergency);
    }
}
