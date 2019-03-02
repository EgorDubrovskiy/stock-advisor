<?php

namespace App\Console\Commands;

use App\Services\Models\PriceUpdateService;
use App\Services\Models\UserService;
use App\WebSocket\PriceUpdateServiceClient;
use App\Websocket\WebSocketPusher;
use Evenement\EventEmitter;
use Illuminate\Console\Command;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use React\EventLoop\Factory;
use React\Socket\Server;
use App\Models\User;

/**
 * Class RunWebsocketServer
 * @package App\Console\Commands
 */
class RunWebsocketServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'runWebsocketServer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs Websocket Server';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param PriceUpdateServiceClient $client
     */
    public function handle(PriceUpdateServiceClient $client)
    {
        $loop = Factory::create();
        $pusher = new WebSocketPusher();

        $emitter = new EventEmitter();
        $emitter->on('companiesUpdated', [$pusher, 'onCompaniesUpdate']);
        $emitter->on('userRegistered', [$pusher, 'onUserRegistration']);

        $loop->addPeriodicTimer(config('websocket.companyPeriodicTimerInterval'), function () use ($client, $emitter) {
            $companies = $client->getPricesOfCompanies();
            $emitter->emit('companiesUpdated', [$companies]);
        });

        $usersBefore = User::all();
        $loop->addPeriodicTimer(config('websocket.usersPeriodicTimerInterval'), function () use (&$usersBefore, $emitter) {
            $usersAfter = User::all();
            if ($usersBefore->count() < $usersAfter->count()) {
                $newUsers = $usersAfter->diff($usersBefore);
                $emitter->emit('userRegistered', [$newUsers]);
            }
            $usersBefore = $usersAfter;
        });

        $webSock = new Server(config('websocket.serverUri'), $loop);
        new IoServer(
            new HttpServer(
                new WsServer(
                    $pusher
                )
            ),
            $webSock
        );

        echo 'Server started' . PHP_EOL;
        $loop->run();
    }
}
