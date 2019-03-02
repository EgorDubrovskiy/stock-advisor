<?php

namespace App\Listeners;

use App\Jobs\SendMail;
use App\Events\BookmarkInserted as BookmarkInsertedEvent;

/**
 * Class BookmarkInserted
 * @package App\Listeners
 */
class BookmarkInserted
{

    /**
     * @param BookmarkInsertedEvent $event
     */
    public function handle(BookmarkInsertedEvent $event)
    {
        $userEmail = $event->user->email;
        $subject = 'Закладка добавлена!';
        $message = 'Уважаемый '.$event->user->login.
            ', компания '.$event->company->symbol.' успешно добавлена в закладки!';

        SendMail::dispatch($userEmail, $subject, $message);
    }
}
