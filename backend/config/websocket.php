<?php

return [
    'serverUri' => env('WEBSOCKET_SERVER_URI', '0.0.0.0:8080'),
    'dsn' => env('WEBSOCKET_DSN', 'tcp://127.0.0.1:5555'),
    'companyPeriodicTimerInterval' => env('WEBSOCKET_COMPANY_PERIODIC_TIMER_INTERVAL', 60),
    'usersPeriodicTimerInterval' => env('WEBSOCKET_USERS_PERIODIC_TIMER_INTERVAL', 30)
];
