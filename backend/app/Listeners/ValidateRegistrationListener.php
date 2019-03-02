<?php

namespace App\Listeners;

use App\Events\ValidateRegistrationEvent;
use App\Jobs\SendMail;

/**
 * Class ValidateRegistrationListener
 * @package App\Listeners
 */
class ValidateRegistrationListener
{
    /**
     * @param ValidateRegistrationEvent $event
     */
    public function handle(ValidateRegistrationEvent $event)
    {
        $userEmail = $event->user->email;
        $subject = 'Account activation';
        $message = 'Hello, ' . $event->user->login.
            ', follow this link to activate your account.'.
            "\n" . env('APP_URL') . ':' . env('APP_FRONTEND_PORT') . '/users/activate/' .
            $event->user->activation_token;
        SendMail::dispatch($userEmail, $subject, $message);
    }
}
