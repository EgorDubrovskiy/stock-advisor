<?php

namespace App\Logging;

use Monolog\Logger;
use App\Handlers\EmailHandler;

class CustomLogger
{
    /**
     * Create a custom Monolog instance.
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config) : Logger
    {
        $monolog = new Logger('custom');

        $monolog->pushHandler(new EmailHandler());

        return $monolog;
    }
}
