<?php

namespace App\Listeners;

use App\Events\ResetPasswordEvent;
use App\Jobs\SendMail;

class ResetPasswordListener
{
    /**
     * @param ResetPasswordEvent $event
     */
    public function handle(ResetPasswordEvent $event)
    {
        $userEmail = $event->user->email;
        $subject = 'Secret token has been generated!';
        $message = $event->user->login.
            ', token: '.$event->passwordReset->token.'';

        SendMail::dispatch($userEmail, $subject, $message);
    }
}
